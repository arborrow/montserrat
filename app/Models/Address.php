<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Address extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'address';

    protected $fillable = ['contact_id', 'location_type_id', 'is_primary', 'street_address', 'supplemental_address_1', 'city', 'state_province_id', 'postal_code', 'country_id'];

    // the contact for whom this is an address for
    public function addressee(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function location(): HasOne
    {
        return $this->hasOne(LocationType::class, 'id', 'location_type_id');
    }

    public function state(): HasOne
    {
        return $this->hasOne(StateProvince::class, 'id', 'state_province_id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function getLocationTypeNameAttribute()
    {
        if (isset($this->location_type_id) && isset($this->location->name)) {
            return $this->location->name;
        } else {
            return;
        }
    }

    public function getStateNameAttribute()
    {
        if (isset($this->state->name)) {
            return $this->state->name;
        } else {
            return;
        }
    }

    public function getCountryNameAttribute()
    {
        if (isset($this->country_id)) {
            return $this->country->name;
        } else {
            return;
        }
    }

    public function getCountryAbbreviationAttribute()
    {
        return (empty($this->country_id)) ? null : $this->country->iso_code;
    }

    public function getGoogleMapAttribute()
    {
        //dd($this);
        if (isset($this->state->abbreviation)) {
            $gmap = '<a href="http://maps.google.com/?q='.$this->street_address.' '.$this->supplemental_address_1.' '.$this->city.' '.$this->state->abbreviation.' '.$this->postal_code.'" target="_blank">'.
                    $this->street_address.' '.$this->supplemental_address_1.' '.$this->city.', '.$this->state->abbreviation.' '.$this->postal_code.'</a>';
        } else {
            $gmap = '<a href="http://maps.google.com/?q='.$this->street_address.' '.$this->supplemental_address_1.' '.$this->city.' '.$this->postal_code.'">'.
                    $this->street_address.' '.$this->supplemental_address_1.' '.$this->city.' '.$this->postal_code.'</a>';
        }

        return $gmap;
    }
}
