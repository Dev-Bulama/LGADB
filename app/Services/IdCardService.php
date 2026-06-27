<?php
namespace App\Services;

use App\Models\Worker;
use App\Models\IdCardTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IdCardService
{
    public function generate(Worker $worker): string
    {
        $qrCode = base64_encode(QrCode::format('png')->size(150)->generate(
            route('verify.qr', $worker->verification_hash)
        ));

        $template = IdCardTemplate::where('is_default', true)->first();

        $pdf = Pdf::loadView('pdf.id-card', [
            'worker'   => $worker,
            'qrCode'   => $qrCode,
            'template' => $template,
        ]);

        // CR80 PVC card size in points (85.6mm x 53.98mm)
        $pdf->setPaper([0, 0, 242.65, 153.07]);

        $dir  = storage_path('app/public/id-cards');
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $path = "{$dir}/{$worker->staff_number}.pdf";
        $pdf->save($path);

        $worker->update(['id_card_generated_at' => now()]);

        return $path;
    }

    public function download(Worker $worker)
    {
        $qrCode = base64_encode(QrCode::format('png')->size(150)->generate(
            route('verify.qr', $worker->verification_hash)
        ));

        $template = IdCardTemplate::where('is_default', true)->first();

        $pdf = Pdf::loadView('pdf.id-card', [
            'worker'   => $worker,
            'qrCode'   => $qrCode,
            'template' => $template,
        ]);

        $pdf->setPaper('a4', 'portrait');

        $filename = 'ID-Card-' . str_replace('/', '-', $worker->staff_number) . '.pdf';

        return $pdf->download($filename);
    }
}
