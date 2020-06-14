<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parish extends Model
{
    use SoftDeletes;
    protected $table = 'contact';

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
        return $this->hasOne(Relationship::class, 'contact_id_a', 'id')->whereRelationshipTypeId(config('polanco.relationship_type.pastor'));
    }

    public function getPastorIdAttribute() {
        if (isset($this->pastor)) {
            return $this->pastor->contact_id_b;
        } else {
            return 0;
        }
    }

}
