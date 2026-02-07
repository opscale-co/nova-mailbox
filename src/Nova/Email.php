<?php

namespace Opscale\NovaMailbox\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Laravel\Nova\Tabs\Tab;
use Opscale\NovaMailbox\Models\Email as Model;
use Opscale\NovaMailbox\Nova\Actions\DownloadEmail;

class Email extends Resource
{
    public static $model = Model::class;

    public static $title = 'subject';

    public static $search = [
        'id',
        'message_id',
        'from',
        'subject',
    ];

    public static function uriKey(): string
    {
        return 'mailbox-emails';
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    public static function label(): string
    {
        return __('Emails');
    }

    public static function singularLabel(): string
    {
        return __('Email');
    }

    public function authorizedToUpdate(Request $request): bool
    {
        return false;
    }

    public function authorizedToDelete(Request $request): bool
    {
        return false;
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Tab::group(__('Email'), [
                Tab::make(__('Details'), [
                    Text::make(__('From'), 'from')->sortable(),
                    MultiSelect::make(__('To'), 'to')
                        ->options(fn () => array_combine($this->resource->to ?? [], $this->resource->to ?? [])),
                    Text::make(__('Alias'), 'alias')->hideFromIndex(),
                    Text::make(__('Subject'), 'subject')
                        ->displayUsing(fn ($value) => str($value)->limit(50))
                        ->sortable(),
                    DateTime::make(__('Date'), 'date')->sortable(),
                    MultiSelect::make(__('CC'), 'cc')
                        ->options(fn () => array_combine($this->resource->cc ?? [], $this->resource->cc ?? []))
                        ->hideFromIndex(),
                    DateTime::make(__('Created At'), 'created_at')
                        ->displayUsing(fn ($value) => $value?->diffForHumans())
                        ->sortable()
                        ->hideFromIndex(),
                    DateTime::make(__('Updated At'), 'updated_at')
                        ->displayUsing(fn ($value) => $value?->diffForHumans())
                        ->sortable()
                        ->hideFromIndex(),
                ]),

                Tab::make(__('Attachments'), [
                    HasMany::make(__('Attachments'), 'attachments', Attachment::class),
                ]),

                Tab::make(__('Extractions'), [
                    HasMany::make(__('Extractions'), 'extractions', Extraction::class),
                ]),
            ]),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            DownloadEmail::make()->showInline()->sole(),
        ];
    }
}
