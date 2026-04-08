<?php

namespace Opscale\NovaMailbox\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Opscale\NovaMailbox\Models\Attachment;
use Opscale\NovaMailbox\Models\Email;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    public function downloadEmail(string $id): StreamedResponse
    {
        $email = Email::findOrFail($id);

        abort_unless($email->uri, 404);

        return Storage::disk(config('mailbox.disk'))->download($email->uri, $email->subject . '.eml');
    }

    public function downloadAttachment(string $id): StreamedResponse
    {
        $attachment = Attachment::findOrFail($id);

        abort_unless($attachment->uri, 404);

        return Storage::disk(config('mailbox.disk'))->download($attachment->uri, $attachment->filename);
    }
}
