<?php

namespace Opscale\NovaMailbox\Models;

use Enigma\ValidatorTrait;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $email_id
 * @property string $filename
 * @property string $content_type
 * @property int $size
 * @property string|null $content_id
 * @property string $uri
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Opscale\NovaMailbox\Models\Email $email
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Opscale\NovaMailbox\Models\Extraction> $extractions
 */
class Attachment extends Model
{
    use HasUlids;
    use ValidatorTrait;

    /** @var string */
    protected $table = 'mailbox_attachments';

    /** @var list<string> */
    protected $fillable = [
        'email_id',
        'filename',
        'content_type',
        'size',
        'content_id',
        'uri',
        'data',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'size' => 'integer',
        'data' => 'array',
    ];

    /** @var array<string, list<string>> */
    protected $validationRules = [
        'email_id' => ['required', 'string', 'exists:mailbox_emails,id'],
        'filename' => ['required', 'string', 'max:255'],
        'content_type' => ['required', 'string', 'max:255'],
        'size' => ['required', 'integer', 'min:0'],
        'content_id' => ['nullable', 'string', 'max:255'],
        'uri' => ['required', 'string', 'max:255'],
        'data' => ['nullable', 'array'],
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class, 'email_id');
    }

    public function extractions(): HasMany
    {
        return $this->hasMany(Extraction::class, 'attachment_id');
    }
}
