<?php

namespace App\Enums;

enum ScrapeStatus: string
{
    case NEEDS_DATA = 'needs_data';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
}
