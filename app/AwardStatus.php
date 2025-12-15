<?php

namespace App;

enum AwardStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case VOTING = 'voting';
    case FINISHED = 'finished';

    public static function all(): array
    {
       return array_column(self::cases(), 'value');
    }
}


