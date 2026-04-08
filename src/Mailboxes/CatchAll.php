<?php

namespace Opscale\NovaMailbox\Mailboxes;

use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Opscale\NovaMailbox\Contracts\Extractor;
use Opscale\NovaMailbox\Models\Attachment;
use Opscale\NovaMailbox\Models\Email;

class CatchAll
{
    public function __invoke(InboundEmail $email): void
    {
        $path = $this->storeEmail($email);

        $record = Email::create([
            'message_id' => $email->id(),
            'in_reply_to' => $email->headerValue('In-Reply-To'),
            'from' => $email->from(),
            'to' => Collection::make($email->to())->map->getEmail()->toArray(),
            'cc' => Collection::make($email->cc())->map->getEmail()->toArray(),
            'bcc' => Collection::make($email->bcc())->map->getEmail()->toArray(),
            'reply_to' => $email->headerValue('Reply-To') ? [$email->headerValue('Reply-To')] : [],
            'subject' => $email->subject(),
            'date' => $email->date(),
            'uri' => $path,
        ]);

        foreach ($email->attachments() as $attachment) {
            $this->storeAttachment($record, $attachment);
        }

        $this->extractData($email);
    }

    protected function storeEmail(InboundEmail $email): string
    {
        $path = sprintf('%s/emails/%s.eml', config('mailbox.path'), $email->id());

        Storage::disk(config('mailbox.disk'))->put($path, $email->getAttribute('message'));

        return $path;
    }

    protected function storeAttachment(Email $email, $attachment): void
    {
        $path = sprintf('%s/attachments/%s/%s', config('mailbox.path'), $email->id, $attachment->getFilename());

        Storage::disk(config('mailbox.disk'))->put($path, $attachment->getContent());

        Attachment::create([
            'email_id' => $email->id,
            'filename' => $attachment->getFilename(),
            'content_type' => $attachment->getContentType(),
            'size' => strlen($attachment->getContent()),
            'content_id' => $attachment->getContentId(),
            'uri' => $path,
        ]);
    }

    protected function extractData(InboundEmail $email): void
    {
        foreach (config('mailbox.extraction_rules', []) as $ruleClass) {
            $rule = app($ruleClass);

            if ($rule instanceof Extractor && $rule->matches($email)) {
                $rule->process($email);
            }
        }
    }
}
