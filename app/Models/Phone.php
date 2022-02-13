<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Phone extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'phone';

    protected $fillable = ['contact_id', 'location_type_id', 'is_primary', 'phone', 'phone_type'];

    public function owner()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id', 'id');
    }

    public function getPhoneExtensionAttribute()
    {
        if (empty($this->phone_ext)) {
            return;
        } else {
            return ','.$this->phone_ext;
        }
    }

    public function getLocationTypeNameAttribute()
    {
        if (isset($this->location_type_id) && isset($this->location->name)) {
            return $this->location->name;
        } else {
            return;
        }
    }

    public function setPhoneAttribute($phone)
    {
        $phone_extension = '';
        $phone_numeric = $phone;
        $phone_numeric = str_replace(' ', '', $phone_numeric);
        $phone_numeric = str_replace('(', '', $phone_numeric);
        $phone_numeric = str_replace(')', '', $phone_numeric);
        $phone_numeric = str_replace('-', '', $phone_numeric);
        $phone_numeric = str_replace('ext.', ',', $phone_numeric);
        $phone_numeric = str_replace('x', ',', $phone_numeric);

        if (strpos($phone_numeric, ',') > 0) {
            $phone_extension = substr($phone_numeric, strpos($phone_numeric, ',') + 1);
            $phone_numeric = substr($phone_numeric, 0, strpos($phone_numeric, ','));
        }

        if (strlen($phone_numeric) == 10) { // if US number then format
            $phone_formatted = '('.substr($phone_numeric, 0, 3).') '.substr($phone_numeric, 3, 3).'-'.substr($phone_numeric, 6, 4);
        } else { //if International then store as all numbers
            $phone_formatted = $phone_numeric;
        }
//        dd($phone_formatted,$phone_extension,$phone_numeric);
        if (empty($phone_extension)) {
            $this->attributes['phone'] = $phone_formatted;
            $this->attributes['phone_numeric'] = $phone_numeric;
        } else {
            $this->attributes['phone'] = $phone_formatted;
            $this->attributes['phone_ext'] = $phone_extension;
            $this->attributes['phone_numeric'] = $phone_numeric;
        }
    }
}
