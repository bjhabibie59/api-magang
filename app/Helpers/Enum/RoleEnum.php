<?php

namespace App\Helpers\Enum;

enum RoleEnum: string
{
    case SUPERADMIN = "superadmin";
    case ADMIN      = "admin";
    case TEACHER    = "teacher";
    case STUDENT    = "student";

    public static function all(): string
    {
        return implode('|', array_column(self::cases(), 'value'));
    }
}
