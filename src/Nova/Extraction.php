<?php

namespace Opscale\NovaMailbox\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Opscale\NovaDynamicResources\Nova\Concerns\UsesTemplate;
use Opscale\NovaMailbox\Models\Enums\ExtractionStatus;
use Opscale\NovaMailbox\Models\Extraction as Model;

class Extraction extends Resource
{
    use UsesTemplate;

    public static $model = Model::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static function uriKey(): string
    {
        return 'mailbox-extractions';
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    public static function label(): string
    {
        return __('Extractions');
    }

    public static function singularLabel(): string
    {
        return __('Extraction');
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

            Badge::make(__('Status'), 'status')
                ->map([
                    ExtractionStatus::Pending->value => 'info',
                    ExtractionStatus::Processing->value => 'warning',
                    ExtractionStatus::Completed->value => 'success',
                    ExtractionStatus::Failed->value => 'danger',
                ])
                ->sortable(),

            Text::make(__('Message'), 'message')
                ->hideFromIndex()
                ->canSee(fn () => filled($this->resource->message)),

            ...$this->renderTemplateFields(),

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
}
