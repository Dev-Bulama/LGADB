<?php
namespace App\Services;

use App\Models\Worker;
use App\Models\IdCardTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IdCardService
{
    private function buildPdf(Worker $worker): array
    {
        $qrCode = base64_encode(QrCode::format('png')->size(150)->generate(
            route('verify.qr', $worker->verification_hash)
        ));

        $template = IdCardTemplate::where('is_default', true)->first()
            ?? IdCardTemplate::where('is_active', true)->first();

        $pdf = Pdf::loadView('pdf.id-card', [
            'worker'   => $worker->load(['department', 'unit', 'office']),
            'qrCode'   => $qrCode,
            'template' => $template,
        ]);

        // CR80 PVC card size in points (85.6mm x 53.98mm)
        $pdf->setPaper([0, 0, 242.65, 153.07]);

        return [$pdf, str_replace('/', '-', $worker->staff_number)];
    }

    public function generate(Worker $worker): string
    {
        [$pdf, $safeNumber] = $this->buildPdf($worker);

        $dir = storage_path('app/public/id-cards');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $path = "{$dir}/{$safeNumber}.pdf";
        $pdf->save($path);

        $worker->update(['id_card_generated_at' => now()]);

        return $path;
    }

    public function download(Worker $worker)
    {
        [$pdf, $safeNumber] = $this->buildPdf($worker);

        return $pdf->download("ID-Card-{$safeNumber}.pdf");
    }
}
