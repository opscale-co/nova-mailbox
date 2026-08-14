<?php

namespace Workbench\App\Providers;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Workbench\App\Channels\StdoutChannel;
use Workbench\App\Console\Commands\SendTestEmail;
use Workbench\App\Extractors\SecretCodeExtractor;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        config()->set('mailbox.extraction_rules', [
            SecretCodeExtractor::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('stdout', function ($app) {
                return new StdoutChannel;
            });
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                SendTestEmail::class,
            ]);
        }
    }
}
