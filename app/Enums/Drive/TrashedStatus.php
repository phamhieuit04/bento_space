<?php

namespace App\Enums\Drive;

enum TrashedStatus: int
{
    case TRASHED = 1;
    case NOT_TRASHED = 0;
}
