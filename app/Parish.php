<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parish extends Model
{
     use SoftDeletes;
    protected $table = 'parishes';

    //
    public function diocese()
    {
        return $this->belongsTo(Diocese::class, 'diocese_id', 'id');
    }

    public function parishioners()
    {
        return $this->hasMany(Relationship::class, 'contact_id_a', 'id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_PARISHIONER);
    }
    
    public function pastor()
    {
        return $this->hasOne(Person::class, 'id', 'pastor_id');
    }
}
