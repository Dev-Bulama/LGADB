<?php

namespace App\Enums;

enum EmploymentType: string
{
    case Permanent = 'permanent';
    case Contract = 'contract';
    case Temporary = 'temporary';
    case Casual = 'casual';

    public function label(): string
    {
        return match($this) {
            self::Permanent => 'Permanent',
            self::Contract => 'Contract',
            self::Temporary => 'Temporary',
            self::Casual => 'Casual',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }
}
