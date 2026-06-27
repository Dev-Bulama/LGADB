<?php

namespace App\Filament\Resources\VerificationLogResource\Pages;

use App\Filament\Resources\VerificationLogResource;
use Filament\Resources\Pages\ListRecords;

class ListVerificationLogs extends ListRecords
{
    protected static string $resource = VerificationLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
