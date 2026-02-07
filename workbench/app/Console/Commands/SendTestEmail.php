<?php

namespace Workbench\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'mailbox:test {--to=admin@laravel.com : The recipient email address}';

    protected $description = 'Send a test email to trigger the mailbox catchall';

    public function handle(): int
    {
        $to = $this->option('to');

        $this->info("Sending test email to {$to}...");

        Mail::raw('This is a test email body for mailbox testing.', function ($message) use ($to) {
            $message->to($to)
                ->from('sender@example.com', 'Test Sender')
                ->subject('Test Email - ' . now()->format('Y-m-d H:i:s'))
                ->attachData('Secret code: ALPHA-1234', 'sample.txt', [
                    'mime' => 'text/plain',
                ]);
        });

        $this->info('Test email sent successfully.');
        $this->info('Check your laravel.log file if using the log driver.');

        return self::SUCCESS;
    }
}
