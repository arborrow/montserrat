<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parish extends Model
{
    use SoftDeletes;

    //
    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'diocese_id', 'id');
    }

    public function parishioners()
    {
        return $this->hasMany(Relationship::class, 'contact_id_a', 'id')->whereRelationshipTypeId(config('polanco.relationship_type.parishioner'));
    }

    public function pastor()
    {
        return $this->hasOne(Person::class, 'id', 'pastor_id');
    }
}
