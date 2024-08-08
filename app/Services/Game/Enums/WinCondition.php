<?php

namespace App\Services\Game\Enums;

enum WinCondition: string
{
    case HIGH = 'high';
    case MEDIUM = 'medium';
    case LOW = 'low';
    case DEFAULT = 'default';

    public function applies(int $randomNumber): bool
    {
        return match($this) {
            self::HIGH => $randomNumber > 900,
            self::MEDIUM => $randomNumber > 600,
            self::LOW => $randomNumber > 300,
            self::DEFAULT => $randomNumber <= 300,
        };
    }

    public function calculateWinAmount(int $randomNumber): float
    {
        return match ($this) {
            self::HIGH => $randomNumber * 0.7,
            self::MEDIUM => $randomNumber * 0.5,
            self::LOW => $randomNumber * 0.3,
            self::DEFAULT => $randomNumber * 0.1,
        };
    }
}
