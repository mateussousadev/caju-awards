<?php

namespace App;

enum CategoryType: string
{
    case PUBLIC_VOTE = 'public_vote';
    case ADMIN_CHOICE = 'admin_choice';
    case QUANTITATIVE = 'quantitative';
    case JURY = 'jury';
    case MIXED = 'mixed';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
