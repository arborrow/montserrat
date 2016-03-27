<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Relationship extends Model
{
    use SoftDeletes;
    protected $table = 'relationship';
    public function relationship_type() {
        return $this->hasOne('\montserrat\RelationshipType','id','relationship_type_id');
    }
    
    public function contact_a() {
        return $this->hasOne('\montserrat\Contact','id','contact_id_a');
    }
    
    public function contact_b() {
        return $this->hasOne('\montserrat\Contact','id','contact_id_b');
    }
}
