<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    
class Address extends Model
{
    use SoftDeletes;
    protected $table = 'address';
    protected $fillable =  ['contact_id', 'location_type_id', 'is_primary', 'street_address', 'supplemental_address_1', 'city','state_province_id','postal_code','country_id'];
    
    public function owner() {
        return $this->belongsTo('\montserrat\Person','contact_id','id');
    }
    
    public function location() {
        return $this->belongsTo('\montserrat\LocationType','location_type_id','id');
    }
    
    public function state() {
        return $this->belongsTo('\montserrat\StateProvince','state_province_id','id');
    }
    
    public function country() {
        return $this->belongsTo('\montserrat\Country','country_id','id');
    }
    
}
