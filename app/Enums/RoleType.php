<?php

namespace App\Enums;

enum RoleType: string
{
    case SuperAdmin = 'super_admin';
    case HrOfficer = 'hr_officer';
    case DepartmentManager = 'department_manager';
    case Worker = 'worker';

    public function label(): string
    {
        return match($this) {
            self::SuperAdmin => 'Super Administrator',
            self::HrOfficer => 'HR Officer',
            self::DepartmentManager => 'Department Manager',
            self::Worker => 'Worker',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }
}
