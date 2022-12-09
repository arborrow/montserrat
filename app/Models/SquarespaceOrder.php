<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\PhoneTrait;



class SquarespaceOrder extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use PhoneTrait;

    protected $table = 'squarespace_order';

    protected $fillable = ['order_number'];

    public function message()
    {
        return $this->hasOne(Message::class, 'id', 'message_id');
    }

    public function event()
    {
        return $this->hasOne(Retreat::class, 'id', 'event_id');
    }

    public function retreatant()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function couple()
    {
        return $this->hasOne(Contact::class, 'id', 'couple_contact_id');
    }

    public function registration()
    {
        return $this->hasOne(Registration::class, 'id', 'participant_id');
    }

    public function getIsCoupleAttribute() {
        return ($this->retreat_couple == "Couple" || $this->retreat_couple == "Pareja");
    }

    public function getIsGiftCertificateAttribute() {
        return ($this->retreat_category == "Retreat Gift Certificate");
    }

    public function getMobilePhoneFormattedAttribute() {
        $clean_phone = $this->format_phone($this->mobile_phone);
        return $clean_phone['phone_formatted'];
    }
    public function getCoupleMobilePhoneFormattedAttribute() {
        $clean_phone = $this->format_phone($this->couple_mobile_phone);
        return $clean_phone['phone_formatted'];
    }

    public function getHomePhoneFormattedAttribute() {
        $clean_phone = $this->format_phone($this->home_phone);
        return $clean_phone['phone_formatted'];
    }
    public function getCoupleHomePhoneFormattedAttribute() {
        $clean_phone = $this->format_phone($this->couple_home_phone);
        return $clean_phone['phone_formatted'];
    }
    public function getWorkPhoneFormattedAttribute() {
        $clean_phone = $this->format_phone($this->work_phone);
        return $clean_phone['phone_formatted'];
    }


}
