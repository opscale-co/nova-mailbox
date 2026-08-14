<?php

namespace Opscale\NovaMailbox\Tests;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;

class ToolControllerTest extends TestCase
{
    #[Test]
    public function it_registers_the_package_routes()
    {
        $this->assertTrue(Route::has('mailbox.emails.download'));
        $this->assertTrue(Route::has('mailbox.attachments.download'));
    }
}
