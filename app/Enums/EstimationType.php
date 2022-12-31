<?php

namespace App\Enums;

use App\Traits\Enumerable;

enum EstimationType: string
{
    use Enumerable;

    case MINUTES    = 'minutes';
    case HOURS      = 'hours';
    case DAYS       = 'days';
}
