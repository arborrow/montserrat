<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    
class Address extends Model
{
    use SoftDeletes;
    protected $table = 'address';
    protected $fillable =  ['contact_id', 'location_type_id', 'is_primary', 'street_address', 'supplemental_address_1', 'city','state_province_id','postal_code','country_id'];
    
    // the contact for whom this is an address for
    public function addressee() {
        return $this->belongsTo('\montserrat\Contact','contact_id','id');
    }
    
    public function location() {
        return $this->hasOne('\montserrat\LocationType','id','location_type_id');
    }
    
    public function state() {
        return $this->hasOne('\montserrat\StateProvince','id','state_province_id');
    }
    
    public function country() {
        return $this->hasOne('\montserrat\Country','id','country_id');
    }
    
    public function getGoogleMapAttribute() {
        //dd($this);
        if (isset($this->state->abbreviation)) {
            $gmap = '<a href="http://maps.google.com/?q='.$this->street_address.' '.$this->supplemental_address.' '.$this->city.' '.$this->state->abbreviation.' '.$this->postal_code.'" target="_blank">'.
                    $this->street_address.' '.$this->supplemental_address.' '.$this->city.', '.$this->state->abbreviation.' '.$this->postal_code.'</a>';
        } else {
            $gmap = '<a href="http://maps.google.com/?q='.$this->street_address.' '.$this->supplemental_address.' '.$this->city.' '.$this->postal_code.'">'.
                    $this->street_address.' '.$this->supplemental_address.' '.$this->city.' '.$this->postal_code.'</a>';
        } 
        return $gmap;
    }

    
    
}
