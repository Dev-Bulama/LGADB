<?php

namespace App\Filament\Resources\WorkerResource\Pages;

use App\Filament\Resources\WorkerResource;
use App\Enums\WorkerStatus;
use App\Enums\VerificationStatus;
use App\Services\IdCardService;
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
                    if ($this->record->user?->email) {
                        $this->record->user->notify(new \App\Notifications\WorkerVerifiedNotification($this->record));
                    }
                    Notification::make()
                        ->title('Worker Verified')
                        ->success()
                        ->send();
                    $this->redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
                })
                ->visible(fn () => $this->record->verification_status !== VerificationStatus::Approved),

            Actions\Action::make('suspend')
                ->label('Suspend Worker')
                ->icon('heroicon-o-no-symbol')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => WorkerStatus::Suspended]);
                    if ($this->record->user?->email) {
                        $this->record->user->notify(new \App\Notifications\WorkerSuspendedNotification($this->record));
                    }
                    Notification::make()
                        ->title('Worker Suspended')
                        ->warning()
                        ->send();
                    $this->redirect($this->getResource()::getUrl('view', ['record' => $this->record]));
                })
                ->visible(fn () => $this->record->status !== WorkerStatus::Suspended),

            Actions\Action::make('generate_id')
                ->label('Generate ID Card')
                ->icon('heroicon-o-identification')
                ->color('info')
                ->requiresConfirmation()
                ->action(function () {
                    try {
                        (new IdCardService())->generate($this->record);
                        Notification::make()
                            ->title('ID Card Generated')
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('ID Card generation failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
