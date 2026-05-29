<?php

namespace App\Helpers\Enum;

enum ReportStatusEnum: string
{
    case PENDING  = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
