<?php
namespace App\Services;

use App\Models\Worker;
use App\Models\IdCardTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IdCardService
{
    // CR80 card: 85.6mm × 54mm. Two pages (front + back) → total height 108mm.
    // In points at 72dpi: 85.6mm = 242.65pt, 54mm = 153.07pt per page.
    // We set paper to hold both pages stacked: height = 153.07 × 2 = 306.14pt.
    // DomPDF page-break-after: always splits them cleanly.
    private const PAPER = [0, 0, 242.65, 306.14];

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

        $pdf->setPaper(self::PAPER);

        // Allow local file access for profile photos
        $pdf->getDomPDF()->set_option('isRemoteEnabled', false);
        $pdf->getDomPDF()->set_option('isLocalEnabled', true);
        $pdf->getDomPDF()->set_option('chroot', storage_path());

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
