<?php

namespace App\Enums\Drive;

enum TrashedDate: string
{
    case TODAY = 'Today';
    case YESTERDAY = 'Yesterday';
    case LONG_TIME_AGO = 'Long time ago';
}
