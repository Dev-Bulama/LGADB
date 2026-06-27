<?php

namespace App\Filament\Resources\WorkerResource\Pages;

use App\Filament\Resources\WorkerResource;
use App\Enums\WorkerStatus;
use App\Enums\VerificationStatus;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewWorker extends ViewRecord
{
    protected static string $resource = WorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\Action::make('verify')
                ->label('Verify Worker')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'status' => WorkerStatus::Active,
                        'verification_status' => VerificationStatus::Approved,
                        'verified_at' => now(),
                        'verified_by' => auth()->id(),
                    ]);
                    Notification::make()
                        ->title('Worker Verified')
                        ->success()
                        ->send();
                    $this->refreshFormData(['status', 'verification_status', 'verified_at']);
                })
                ->visible(fn () => $this->record->verification_status !== VerificationStatus::Approved),

            Actions\Action::make('suspend')
                ->label('Suspend Worker')
                ->icon('heroicon-o-no-symbol')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => WorkerStatus::Suspended]);
                    Notification::make()
                        ->title('Worker Suspended')
                        ->warning()
                        ->send();
                    $this->refreshFormData(['status']);
                })
                ->visible(fn () => $this->record->status !== WorkerStatus::Suspended),

            Actions\Action::make('generate_id')
                ->label('Generate ID Card')
                ->icon('heroicon-o-identification')
                ->color('info')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['id_card_generated_at' => now()]);
                    Notification::make()
                        ->title('ID Card Generated')
                        ->success()
                        ->send();
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
