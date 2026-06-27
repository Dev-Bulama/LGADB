<?php

namespace App\Console\Commands;

use App\Models\Worker;
use App\Services\IdCardService;
use App\Enums\VerificationStatus;
use Illuminate\Console\Command;

class GenerateWorkerIdCards extends Command
{
    protected $signature = 'workers:generate-id-cards {--worker= : Worker ID to generate for}';
    protected $description = 'Generate ID cards for verified workers';

    public function handle(IdCardService $service): int
    {
        $query = Worker::where('verification_status', VerificationStatus::Approved->value)
            ->whereNull('id_card_generated_at');

        if ($this->option('worker')) {
            $query->where('id', $this->option('worker'));
        }

        $workers = $query->get();

        if ($workers->isEmpty()) {
            $this->info('No workers pending ID card generation.');
            return 0;
        }

        $bar = $this->output->createProgressBar($workers->count());
        $bar->start();

        foreach ($workers as $worker) {
            try {
                $service->generate($worker);
                $bar->advance();
            } catch (\Exception $e) {
                $this->error("\nFailed for {$worker->staff_number}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Generated {$workers->count()} ID cards.");

        return 0;
    }
}
