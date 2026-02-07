<?php

namespace Opscale\NovaMailbox\Tests;

use Illuminate\Support\Facades\Route;
use Opscale\NovaMailbox\ToolServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);
    }

    protected function getPackageProviders($app)
    {
        return [
            ToolServiceProvider::class,
        ];
    }
}
