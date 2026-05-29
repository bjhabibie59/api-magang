<?php

namespace App\Helpers\Enum;

enum AttendanceStatusEnum: string
{
    case HADIR          = 'hadir';
    case BELUM_CHECKOUT = 'belum_checkout';
}
