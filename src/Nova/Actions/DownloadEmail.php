<?php

namespace Opscale\NovaMailbox\Nova\Actions;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Opscale\NovaMailbox\Models\Email;

class DownloadEmail extends Action
{
    public $showInline = true;

    public $showOnDetail = true;

    public $showOnIndex = false;

    public $showOnTableRow = true;

    public function name(): string
    {
        return __('Download');
    }

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        /** @var Email $email */
        $email = $models->first();

        return ActionResponse::download(
            route('mailbox.emails.download', $email->id),
            "{$email->id}.eml"
        );
    }

    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
