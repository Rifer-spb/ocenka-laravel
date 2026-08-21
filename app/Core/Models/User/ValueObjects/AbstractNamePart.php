<?php

namespace App\Core\Models\User\ValueObjects;

use InvalidArgumentException;

abstract class AbstractNamePart
{
    protected const MAX_LENGTH = 100;

    private ?string $value;

    public function __construct(?string $value)
    {
        if (is_string($value)) {
            $value = $this->normalize($value);
            $length = mb_strlen($value);

            if ($length > static::MAX_LENGTH) {
                throw new InvalidArgumentException($this->getMaxLengthErrorMessage());
            }
        }

        $this->value = $value;
    }

    private function normalize(string $value): string
    {
        $value = trim($value);

        // 1. Находим все последовательности букв (слова)
        preg_match_all('/[a-zA-Zа-яА-ЯёЁ]+/u', $value, $matches);

        // 2. Соединяем слова через пробел
        return implode(' ', $matches[0]);
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    abstract protected function getFieldName() : string;

    private function getMaxLengthErrorMessage() : string
    {
        return "Значение поля {$this->getFieldName()} не должно превышать " . self::MAX_LENGTH . " символов.";
    }
}
