<?php

namespace App\Enums\Drive;

enum TrashStatus: int
{
    case TRASHED = 1;
    case NOT_TRASHED = 0;
}
