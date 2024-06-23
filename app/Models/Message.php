<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Message extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $fillable = ['mailgun_id', 'mailgun_timestamp', 'storage_url', 'from', 'to', 'subject', 'from_id', 'to_id', 'is_processed'];

    protected function casts(): array
    {
        return [
            'mailgun_timestamp' => 'datetime',
            'disabled_at' => 'datetime',
        ];
    }

    public function contact_from(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'from_id', 'id');
    }

    public function contact_to(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'to_id', 'id');
    }
}
