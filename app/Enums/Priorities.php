<?php

namespace App\Enums;

use App\Traits\Enumerable;

enum Priorities: string
{
    use Enumerable;

    case LOW    = 'low';
    case MEDIUM = 'medium';
    case HIGH   = 'high';
}
