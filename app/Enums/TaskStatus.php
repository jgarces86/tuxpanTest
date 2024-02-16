<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case Progress = 'in_progress';
    case Completed = 'completed';

    public static function getValues(): array {
        return array_column(self::cases(), 'value');
    }
}

?>