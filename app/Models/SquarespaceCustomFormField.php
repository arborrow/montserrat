<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SquarespaceCustomFormField extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'squarespace_custom_form_field';

    public function form(): BelongsTo
    {
        return $this->belongsTo(SquarespaceCustomForm::class, 'form_id', 'id');
    }
}
