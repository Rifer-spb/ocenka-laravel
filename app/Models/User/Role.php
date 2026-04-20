<?php

namespace App\Models\User;

enum Role: string
{
    case PHYS = 'phys';
    case LEGAL = 'legal';
    case CLIENT = 'client';
    case NOTARY = 'notary';

    public static function isValid(string $role): bool
    {
        return in_array($role, array_column(self::cases(), 'value'));
    }

    public static function isPhys(string $role): bool
    {
        return $role == self::PHYS;
    }

    public static function isLegal(string $role): bool
    {
        return $role == self::LEGAL;
    }

    public static function isClient(string $role): bool
    {
        return $role == self::CLIENT;
    }

    public static function isNotary(string $role): bool
    {
        return $role == self::NOTARY;
    }

    public static function managerRoles(): array
    {
        return [self::PHYS->value, self::LEGAL->value];
    }
}
