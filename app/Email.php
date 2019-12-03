<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;
    protected $table = 'email';
    protected $fillable = ['contact_id', 'location_type_id', 'is_primary', 'email'];

    public function owner()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id', 'id');
    }
}
