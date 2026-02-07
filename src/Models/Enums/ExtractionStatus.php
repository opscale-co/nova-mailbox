<?php

namespace Opscale\NovaMailbox\Models\Enums;

enum ExtractionStatus: string
{
    case Pending = 'Pending';
    case Processing = 'Processing';
    case Completed = 'Completed';
    case Failed = 'Failed';
}
