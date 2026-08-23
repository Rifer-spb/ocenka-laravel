<?php

namespace App\Core\Models\User\Phys\ValueObjects;

use Carbon\Carbon;
use InvalidArgumentException;

/**
 * Тесты @see \Tests\Unit\Core\Models\User\Phys\ValueObjects\HolidayTest
 */
class Holiday
{
    private ?Carbon $from = null;
    private ?Carbon $to = null;

    public function __construct(?string $from, ?string $to)
    {
        $from = trim($from);
        $to = trim($to);

        if (!empty($from) && !empty($to)) {
            $this->from = Carbon::parse($from);
            $this->to = Carbon::parse($to);

            $this->validate();
        }
    }

    private function validate(): void
    {
        if ($this->to->lte($this->from)) {
            throw new InvalidArgumentException(
                'Дата окончания отпуска должна быть позже даты начала'
            );
        }
    }

    public function getFrom(): ?Carbon
    {
        return $this->from;
    }

    public function getTo(): ?Carbon
    {
        return $this->to;
    }

    public function getFromString(): ?string
    {
        if (!$this->from) {
            return null;
        }

        return $this->from->toDateString();
    }

    public function getToString(): ?string
    {
        if (!$this->to) {
            return null;
        }

        return $this->to->toDateString();
    }
}
