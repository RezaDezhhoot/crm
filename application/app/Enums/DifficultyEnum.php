<?php

namespace App\Enums;

enum DifficultyEnum: string
{
    case HARD = 'hard';
    case MEDIUM = 'medium';
    case EASY = 'easy';

    public function label() {
        return match ($this) {
            self::HARD => 'دشوار',
            self::MEDIUM => 'متوسط',
            self::EASY => 'ساده'
        };
    }
}
