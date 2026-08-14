<?php

namespace Opscale\NovaMailbox\Tests;

use BeyondCode\Mailbox\MailboxServiceProvider;
use Illuminate\Support\Facades\Route;
use Opscale\NovaMailbox\ToolServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);
    }

    protected function getPackageProviders($app)
    {
        return [
            MailboxServiceProvider::class,
            ToolServiceProvider::class,
        ];
    }
}
