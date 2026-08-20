<?php

namespace App\Core\Models\User;

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

    public function isPhys(): bool
    {
        return $this === self::PHYS;
    }

    public function isLegal(): bool
    {
        return $this === self::LEGAL;
    }

    public function isClient(): bool
    {
        return $this === self::CLIENT;
    }

    public function isNotary(): bool
    {
        return $this === self::NOTARY;
    }

    public static function getManagerRoleValues(): array
    {
        return [self::PHYS->value, self::LEGAL->value];
    }

    public function isManager(): bool
    {
        return match ($this) {
            self::PHYS, self::LEGAL => true,
            default => false,
        };
    }
}
