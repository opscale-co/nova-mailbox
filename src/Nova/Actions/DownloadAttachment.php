<?php

namespace Opscale\NovaMailbox\Nova\Actions;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Opscale\NovaMailbox\Models\Attachment;

class DownloadAttachment extends Action
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
        /** @var Attachment $attachment */
        $attachment = $models->first();

        return ActionResponse::download(
            route('mailbox.attachments.download', $attachment->id),
            $attachment->filename
        );
    }

    public function fields(NovaRequest $request): array
    {
        return [];
    }
}
