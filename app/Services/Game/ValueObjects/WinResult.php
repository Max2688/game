<?php

namespace App\Services\Game\ValueObjects;

use App\Services\Game\Enums\WinCondition;

class WinResult
{
    const WIN = 'Win';
    const LOSE = 'Lose';

    private int $randomNumber;

    private string  $result;

    private float $winAmount;

    /**
     * @param int $randomNumber
     */
    public function __construct(int $randomNumber)
    {
        $this->randomNumber = $randomNumber;
        $this->result = $randomNumber % 2 == 0 ? self::WIN : self::LOSE;
        $this->winAmount = $this->calculateWinAmount();
    }

    public function calculateWinAmount()
    {
        if ($this->result === self::LOSE) {
            return 0;
        }

        foreach (WinCondition::cases() as $condition) {
            if ($condition->applies($this->randomNumber)) {
                return $condition->calculateWinAmount($this->randomNumber);
            }
        }

        return 0;
    }

    /**
     * @return int
     */
    public function getRandomNumber(): int
    {
        return $this->randomNumber;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @return float
     */
    public function getWinAmount(): float
    {
        return $this->winAmount;
    }

}
