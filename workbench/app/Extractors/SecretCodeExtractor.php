<?php

namespace Workbench\App\Extractors;

use BeyondCode\Mailbox\InboundEmail;
use Opscale\NovaDynamicResources\Models\Template;
use Opscale\NovaMailbox\Contracts\Extractor;
use Opscale\NovaMailbox\Models\Email;
use Opscale\NovaMailbox\Models\Enums\ExtractionStatus;
use Opscale\NovaMailbox\Models\Extraction;

class SecretCodeExtractor implements Extractor
{
    public function matches(InboundEmail $email): bool
    {
        foreach ($email->attachments() as $attachment) {
            if ($attachment->getFilename() === 'sample.txt') {
                return true;
            }
        }

        return false;
    }

    public function process(InboundEmail $email): ?Extraction
    {
        $content = null;

        foreach ($email->attachments() as $attachment) {
            if ($attachment->getFilename() === 'sample.txt') {
                $content = $attachment->getContent();
                break;
            }
        }

        if (! $content || ! preg_match('/Secret code[:\s]+(\S+)/', $content, $matches)) {
            return null;
        }

        $record = Email::where('message_id', $email->id())->firstOrFail();
        $template = Template::where('uri_key', 'secret-codes')->firstOrFail();

        return Extraction::create([
            'email_id' => $record->id,
            'template_id' => $template->id,
            'status' => ExtractionStatus::Completed,
            'data' => [
                'secret_code' => $matches[1],
            ],
        ]);
    }
}
