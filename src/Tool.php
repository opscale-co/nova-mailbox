<?php

namespace Opscale\NovaMailbox;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool as NovaTool;
use Opscale\NovaMailbox\Nova\Email;

class Tool extends NovaTool
{
    public function boot()
    {
        // Nova::script('nova-mailbox', __DIR__ . '/../dist/js/tool.js');
        // Nova::style('nova-mailbox', __DIR__ . '/../dist/css/tool.css');
    }

    public function menu(Request $request)
    {
        return MenuSection::resource(Email::class)
            ->icon('mail');
    }
}
