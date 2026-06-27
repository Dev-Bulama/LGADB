<?php

namespace App\Enums;

enum WorkerStatus: string
{
    case Pending = 'pending';
    case Verified = 'verified';
    case Active = 'active';
    case Suspended = 'suspended';
    case Transferred = 'transferred';
    case Retired = 'retired';
    case Resigned = 'resigned';
    case Dismissed = 'dismissed';
    case Deceased = 'deceased';
    case Archived = 'archived';

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::Verified => 'Verified',
            self::Active => 'Active',
            self::Suspended => 'Suspended',
            self::Transferred => 'Transferred',
            self::Retired => 'Retired',
            self::Resigned => 'Resigned',
            self::Dismissed => 'Dismissed',
            self::Deceased => 'Deceased',
            self::Archived => 'Archived',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending => 'warning',
            self::Verified => 'success',
            self::Active => 'success',
            self::Suspended => 'danger',
            self::Transferred => 'info',
            self::Retired => 'gray',
            self::Resigned => 'gray',
            self::Dismissed => 'danger',
            self::Deceased => 'gray',
            self::Archived => 'gray',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }
}
