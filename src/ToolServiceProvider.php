<?php

namespace Opscale\NovaMailbox;

use BeyondCode\Mailbox\Facades\Mailbox;
use Opscale\NovaMailbox\Mailboxes\CatchAll;
use Opscale\NovaMailbox\Nova\Attachment;
use Opscale\NovaMailbox\Nova\Email;
use Opscale\NovaMailbox\Nova\Extraction;
use Opscale\NovaPackageTools\NovaPackage;
use Opscale\NovaPackageTools\NovaPackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

class ToolServiceProvider extends NovaPackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /** @var NovaPackage $package */
        $package
            ->name('nova-mailbox')
            ->hasConfigFile('mailbox')
            ->hasTranslations()
            ->discoversMigrations()
            ->runsMigrations()
            ->hasRoutes(['web'])
            ->hasResources([
                Email::class,
                Attachment::class,
                Extraction::class,
            ])
            ->hasInstallCommand(function (InstallCommand $installCommand): void {
                $installCommand
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('opscale-co/nova-mailbox');
            });
    }

    public function packageBooted(): void
    {
        Mailbox::catchAll(CatchAll::class);
    }
}
