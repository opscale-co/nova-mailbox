<?php

namespace Opscale\NovaMailbox\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Opscale\Validations\Validatable;

/**
 * @property string $id
 * @property string $message_id
 * @property string|null $in_reply_to
 * @property string $from
 * @property array $to
 * @property-read string|null $alias
 * @property array|null $cc
 * @property array|null $bcc
 * @property array|null $reply_to
 * @property string|null $subject
 * @property Carbon|null $date
 * @property string $uri
 * @property array|null $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Attachment> $attachments
 * @property-read Collection<int, Extraction> $extractions
 */
class Email extends Model
{
    use HasUlids;
    use Validatable;

    /** @var string */
    protected $table = 'mailbox_emails';

    /** @var list<string> */
    protected $fillable = [
        'message_id',
        'in_reply_to',
        'from',
        'to',
        'cc',
        'bcc',
        'reply_to',
        'subject',
        'date',
        'uri',
        'data',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'reply_to' => 'array',
        'date' => 'datetime',
        'data' => 'array',
    ];

    /** @var array<string, list<string>> */
    protected $validationRules = [
        'message_id' => ['required', 'string', 'max:255'],
        'in_reply_to' => ['nullable', 'string', 'max:255'],
        'from' => ['required', 'string', 'max:255'],
        'to' => ['required', 'array'],
        'cc' => ['nullable', 'array'],
        'bcc' => ['nullable', 'array'],
        'reply_to' => ['nullable', 'array'],
        'subject' => ['nullable', 'string', 'max:255'],
        'date' => ['nullable', 'date'],
        'uri' => ['required', 'string', 'max:255'],
        'data' => ['nullable', 'array'],
    ];

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'email_id');
    }

    public function extractions(): HasMany
    {
        return $this->hasMany(Extraction::class, 'email_id');
    }

    protected function alias(): Attribute
    {
        return Attribute::get(function () {
            $email = $this->to[0] ?? null;

            if (! $email || ! preg_match('/\+([^@]+)@/', $email, $matches)) {
                return null;
            }

            return $matches[1];
        });
    }
}
