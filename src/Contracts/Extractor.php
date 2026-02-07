<?php

namespace Opscale\NovaMailbox\Contracts;

use BeyondCode\Mailbox\InboundEmail;
use Opscale\NovaMailbox\Models\Extraction;

interface Extractor
{
    public function matches(InboundEmail $email): bool;

    public function process(InboundEmail $email): ?Extraction;
}
