<?php

namespace App\Enums;

enum DocumentType: string
{
    case EmploymentLetter = 'employment_letter';
    case AppointmentLetter = 'appointment_letter';
    case PromotionLetter = 'promotion_letter';
    case Certificate = 'certificate';
    case NationalId = 'national_id';
    case Passport = 'passport';
    case Other = 'other';

    public function label(): string
    {
        return match($this) {
            self::EmploymentLetter => 'Employment Letter',
            self::AppointmentLetter => 'Appointment Letter',
            self::PromotionLetter => 'Promotion Letter',
            self::Certificate => 'Certificate',
            self::NationalId => 'National ID',
            self::Passport => 'Passport',
            self::Other => 'Other',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }
}
