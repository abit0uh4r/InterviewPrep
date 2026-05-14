<?php

namespace App\Enums;

enum ConceptStatus: string
{
    case ToReview = 'to_review';
    case InProgress = 'in_progress';
    case Mastered = 'mastered';

    public function label(): string
    {
        return match ($this) {
            self::ToReview => 'A revoir',
            self::InProgress => 'En cours',
            self::Mastered => 'Maitrise',
        };
    }
}
