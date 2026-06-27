<?php
namespace App\Services;

use App\Models\Worker;
use App\Models\IdCardTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IdCardService
{
    // CR80 card: 85.6mm × 54mm = 242.65pt × 153.07pt (at 72dpi).
    // We set DomPDF DPI to 72 so mm-in-CSS matches the pt-based paper exactly.
    private const W = 242.65; // pt
    private const H = 153.07; // pt

    private function buildPdf(Worker $worker): array
    {
        $qrCode = base64_encode(
            QrCode::format('png')->size(200)->margin(1)->generate(
                route('verify.qr', $worker->verification_hash)
            )
        );

        $template = IdCardTemplate::where('is_default', true)->first()
            ?? IdCardTemplate::where('is_active', true)->first();

        $pdf = Pdf::loadView('pdf.id-card', [
            'worker'   => $worker->load(['department', 'unit', 'office']),
            'qrCode'   => $qrCode,
            'template' => $template,
        ]);

        // DPI = 72 ensures 1mm in CSS = (72/25.4)pt, which matches the pt paper exactly
        $pdf->getDomPDF()->set_option('dpi', 72);
        $pdf->getDomPDF()->set_option('isLocalEnabled', true);
        $pdf->getDomPDF()->set_option('isRemoteEnabled', false);

        // Each PDF page = one CR80 card side; page-break-after:always creates page 2
        $pdf->setPaper([0, 0, self::W, self::H]);

        $safeNumber = str_replace('/', '-', $worker->staff_number);

        return [$pdf, $safeNumber];
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
