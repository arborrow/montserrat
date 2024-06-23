<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diocese extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contact';

    public function getNoteDioceseTextAttribute()
    {
        if (isset($this->note_diocese->note)) {
            return $this->note_diocese->note;
        } else {
            return;
        }
    }

    public function note_diocese(): HasOne
    {
        return $this->hasOne(Note::class, 'entity_id', 'id')->whereEntityTable('contact')->whereSubject('Diocese Note');
    }
}
