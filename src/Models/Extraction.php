<?php

namespace Opscale\NovaMailbox\Models;

use Enigma\ValidatorTrait;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Opscale\NovaDynamicResources\Models\Concerns\UsesTemplate;
use Opscale\NovaMailbox\Models\Enums\ExtractionStatus;

/**
 * @property string $id
 * @property string $email_id
 * @property string $template_id
 * @property ExtractionStatus $status
 * @property string|null $message
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Opscale\NovaMailbox\Models\Email $email
 * @property-read \Opscale\NovaDynamicResources\Models\Template $template
 */
class Extraction extends Model
{
    use HasUlids;
    use UsesTemplate;
    use ValidatorTrait;

    /** @var string */
    protected $table = 'mailbox_extractions';

    /** @var list<string> */
    protected $fillable = [
        'email_id',
        'template_id',
        'status',
        'message',
        'data',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'status' => ExtractionStatus::class,
        'data' => 'array',
    ];

    /** @var array<string, list<string>> */
    protected $validationRules = [
        'email_id' => ['required', 'string', 'exists:mailbox_emails,id'],
        'template_id' => ['required', 'string', 'exists:dynamic_resources_templates,id'],
        'status' => ['required'],
        'message' => ['nullable', 'string'],
        'data' => ['nullable', 'array'],
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class, 'email_id');
    }
}
