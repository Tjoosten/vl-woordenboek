<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ArticleStates: int implements HasLabel
{
    case New = 0;
    case Draft = 1;
    case Approval = 2;
    case Published = 3;
    case Archived = 4;

    /**
     * Returns the human-readable Dutch label for each state
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'suggestie',
            self::Draft => 'Klad versie',
            self::Approval => 'In afwachting',
            self::Published => 'Publicatie',
            self::Archived => 'Gearchiveerd',
        };
    }
}
