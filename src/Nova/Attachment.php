<?php

namespace Opscale\NovaMailbox\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Opscale\NovaMailbox\Models\Attachment as Model;
use Opscale\NovaMailbox\Nova\Actions\DownloadAttachment;

class Attachment extends Resource
{
    public static $model = Model::class;

    public static $title = 'filename';

    public static $search = [
        'id',
        'filename',
        'content_type',
    ];

    public static function uriKey(): string
    {
        return 'mailbox-attachments';
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    public static function label(): string
    {
        return __('Attachments');
    }

    public static function singularLabel(): string
    {
        return __('Attachment');
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
            BelongsTo::make(__('Email'), 'email', Email::class),

            Text::make(__('Filename'), 'filename')
                ->sortable(),

            Text::make(__('Content Type'), 'content_type')
                ->sortable(),

            Number::make(__('Size'), 'size')
                ->displayUsing(function ($value) {
                    if ($value === null) {
                        return null;
                    }
                    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                    $power = $value > 0 ? floor(log($value, 1024)) : 0;

                    return number_format($value / pow(1024, $power), 2) . ' ' . $units[$power];
                })
                ->sortable(),

            DateTime::make(__('Created At'), 'created_at')
                ->displayUsing(fn ($value) => $value?->diffForHumans())
                ->sortable()
                ->hideFromIndex(),

            DateTime::make(__('Updated At'), 'updated_at')
                ->displayUsing(fn ($value) => $value?->diffForHumans())
                ->sortable()
                ->hideFromIndex(),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            DownloadAttachment::make()->showInline()->sole(),
        ];
    }
}
