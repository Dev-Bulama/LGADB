<?php

namespace Database\Seeders;

use App\Models\Worker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class WorkerPhotoSeeder extends Seeder
{
    // African skin tones (R, G, B)
    private array $skinTones = [
        [139, 94, 60],   // medium brown
        [107, 58, 42],   // dark brown
        [160, 113, 43],  // warm tan
        [90, 50, 30],    // deep brown
        [180, 130, 80],  // light-medium brown
        [120, 70, 40],   // mahogany
        [200, 160, 110], // light tan
        [80, 45, 25],    // very dark brown
        [150, 100, 60],  // golden brown
        [100, 60, 35],   // cocoa
    ];

    // Hair colours (dark variants)
    private array $hairColors = [
        [20, 15, 10],
        [30, 20, 10],
        [10, 8, 5],
        [40, 25, 10],
    ];

    public function run(): void
    {
        $workers = Worker::all();

        foreach ($workers as $i => $worker) {
            if ($worker->hasMedia('profile_photo')) {
                continue;
            }

            $skin = $this->skinTones[$i % count($this->skinTones)];
            $hair = $this->hairColors[$i % count($this->hairColors)];

            $path = $this->generatePassportPhoto($skin, $hair, $worker->id);

            $worker->clearMediaCollection('profile_photo');
            $worker->addMedia($path)
                   ->usingName($worker->full_name)
                   ->toMediaCollection('profile_photo');
        }

        $this->command->info('Citizen passport photos seeded.');
    }

    private function generatePassportPhoto(array $skin, array $hair, string $workerId): string
    {
        $w = 300;
        $h = 375; // passport ratio ~4:5

        $img = imagecreatetruecolor($w, $h);

        // Background — light blue-grey (standard passport)
        $bg = imagecolorallocate($img, 210, 220, 235);
        imagefill($img, 0, 0, $bg);

        $skinC  = imagecolorallocate($img, $skin[0], $skin[1], $skin[2]);
        $hairC  = imagecolorallocate($img, $hair[0], $hair[1], $hair[2]);
        $neckC  = imagecolorallocate($img, max(0, $skin[0] - 10), max(0, $skin[1] - 10), max(0, $skin[2] - 10));
        $shirtC = imagecolorallocate($img, 255, 255, 255);
        $eyeC   = imagecolorallocate($img, 30, 20, 10);
        $white  = imagecolorallocate($img, 255, 255, 255);

        // Shirt/shoulders (trapezoid bottom)
        $shirtY = (int)($h * 0.72);
        imagefilledpolygon($img, [
            0, $h,
            $w, $h,
            (int)($w * 0.78), $shirtY,
            (int)($w * 0.22), $shirtY,
        ], $shirtC);

        // Neck
        $neckX = (int)($w * 0.43);
        $neckW = (int)($w * 0.14);
        $neckY = (int)($h * 0.56);
        $neckH = (int)($h * 0.18);
        imagefilledrectangle($img, $neckX, $neckY, $neckX + $neckW, $neckY + $neckH, $neckC);

        // Head (ellipse)
        $headCX = (int)($w / 2);
        $headCY = (int)($h * 0.38);
        $headRX = (int)($w * 0.28);
        $headRY = (int)($h * 0.26);
        imagefilledellipse($img, $headCX, $headCY, $headRX * 2, $headRY * 2, $skinC);

        // Hair (top arc — cap shape)
        $hairH = (int)($headRY * 0.65);
        $hairTop = $headCY - $headRY;
        imagefilledellipse($img, $headCX, $headCY - (int)($headRY * 0.2), (int)($headRX * 2.05), (int)($headRY * 1.5), $hairC);
        // Re-draw skin to trim hair at face level
        imagefilledellipse($img, $headCX, $headCY + (int)($headRY * 0.1), (int)($headRX * 1.9), (int)($headRY * 1.7), $skinC);

        // Eyes
        $eyeY  = $headCY - (int)($headRY * 0.05);
        $eyeLX = $headCX - (int)($headRX * 0.35);
        $eyeRX = $headCX + (int)($headRX * 0.35);
        $eyeW  = (int)($headRX * 0.25);
        $eyeH  = (int)($headRY * 0.14);
        imagefilledellipse($img, $eyeLX, $eyeY, $eyeW, $eyeH, $white);
        imagefilledellipse($img, $eyeRX, $eyeY, $eyeW, $eyeH, $white);
        imagefilledellipse($img, $eyeLX, $eyeY, (int)($eyeW * 0.55), (int)($eyeH * 0.7), $eyeC);
        imagefilledellipse($img, $eyeRX, $eyeY, (int)($eyeW * 0.55), (int)($eyeH * 0.7), $eyeC);

        // Nose (small oval)
        $noseX = $headCX;
        $noseY = $headCY + (int)($headRY * 0.2);
        $noseDark = imagecolorallocate($img, max(0, $skin[0] - 30), max(0, $skin[1] - 30), max(0, $skin[2] - 30));
        imagefilledellipse($img, $noseX, $noseY, (int)($headRX * 0.22), (int)($headRY * 0.12), $noseDark);

        // Mouth (arc)
        $mouthY = $headCY + (int)($headRY * 0.42);
        $mouthC = imagecolorallocate($img, max(0, $skin[0] - 40), max(0, $skin[1] - 50), max(0, $skin[2] - 50));
        imagearc($img, $headCX, $mouthY - (int)($headRY * 0.05), (int)($headRX * 0.45), (int)($headRY * 0.18), 0, 180, $mouthC);

        // Ears
        $earW = (int)($headRX * 0.18);
        $earH = (int)($headRY * 0.25);
        $earY = $headCY + (int)($headRY * 0.05);
        imagefilledellipse($img, $headCX - $headRX + (int)($earW * 0.3), $earY, $earW, $earH, $skinC);
        imagefilledellipse($img, $headCX + $headRX - (int)($earW * 0.3), $earY, $earW, $earH, $skinC);

        $tmpPath = sys_get_temp_dir() . '/worker_photo_' . $workerId . '.jpg';
        imagejpeg($img, $tmpPath, 90);
        imagedestroy($img);

        return $tmpPath;
    }
}
