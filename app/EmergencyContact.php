<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class EmergencyContact extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'emergency_contact';
    protected $fillable = ['contact_id', 'name', 'relationship', 'phone', 'phone_alternate'];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function setPhoneAttribute($phone)
    {
        $phone_formatted = null;
        $phone_numeric = $phone;
        $phone_numeric = str_replace(' ', '', $phone_numeric);
        $phone_numeric = str_replace('(', '', $phone_numeric);
        $phone_numeric = str_replace(')', '', $phone_numeric);
        $phone_numeric = str_replace('-', '', $phone_numeric);
        if (strpos($phone_numeric, ',') > 0) {
            $phone_extension = substr($phone_numeric, strpos($phone_numeric, ',') + 1);
            $phone_numeric = substr($phone_numeric, 0, strpos($phone_numeric, ','));
        }
        if (strlen($phone_numeric) == 10) {
            $phone_formatted = '('.substr($phone_numeric, 0, 3).') '.substr($phone_numeric, 3, 3).'-'.substr($phone_numeric, 6, 4);
        }
        if (empty($phone_extension)) {
            $this->attributes['phone'] = $phone_formatted;
        } else {
            $this->attributes['phone'] = $phone_formatted.','.$phone_extension;
        }
    }

    public function setPhoneAlternateAttribute($phone)
    {
        $phone_formatted = null;
        $phone_numeric = $phone;
        $phone_numeric = str_replace(' ', '', $phone_numeric);
        $phone_numeric = str_replace('(', '', $phone_numeric);
        $phone_numeric = str_replace(')', '', $phone_numeric);
        $phone_numeric = str_replace('-', '', $phone_numeric);
        if (strpos($phone_numeric, ',') > 0) {
            $phone_extension = substr($phone_numeric, strpos($phone_numeric, ',') + 1);
            $phone_numeric = substr($phone_numeric, 0, strpos($phone_numeric, ','));
        }
        if (strlen($phone_numeric) == 10) {
            $phone_formatted = '('.substr($phone_numeric, 0, 3).') '.substr($phone_numeric, 3, 3).'-'.substr($phone_numeric, 6, 4);
        }
        if (empty($phone_extension)) {
            $this->attributes['phone_alternate'] = $phone_formatted;
        } else {
            $this->attributes['phone_alternate'] = $phone_formatted.','.$phone_extension;
        }
    }
}
