<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\PhoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SquarespaceOrder extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use PhoneTrait;
    use SoftDeletes;

    protected $table = 'squarespace_order';

    protected $fillable = ['order_number'];

    public function message(): HasOne
    {
        return $this->hasOne(Message::class, 'id', 'message_id');
    }

    public function event(): HasOne
    {
        return $this->hasOne(Retreat::class, 'id', 'event_id');
    }

    public function retreatant(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function couple(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'couple_contact_id');
    }

    public function registration(): HasOne
    {
        return $this->hasOne(Registration::class, 'id', 'participant_id');
    }

    public function getGiftCertificateIdAttribute()
    {
        if (! empty($this->gift_certificate_year_issued) && ! empty($this->gift_certificate_number)) {
            $gift_certificate = GiftCertificate::whereYear('purchase_date', $this->gift_certificate_year_issued)
                ->where(function ($query) {
                    $query->where('sequential_number', '=', $this->gift_certificate_number)
                        ->orWhere('squarespace_order_number', '=', $this->gift_certificate_number);
                })
                ->first();

            return isset($gift_certificate->id) ? $gift_certificate->id : null;
        }
    }

    public function getEventStartDateAttribute()
    {
        return (! empty($this->event->start_date)) ? $this->event->start_date : null;
    }

    public function getIsCoupleAttribute()
    {
        return $this->retreat_couple == 'Couple' || $this->retreat_couple == 'Pareja';
    }

    public function getIsGiftCertificateAttribute()
    {
        return $this->retreat_category == 'Retreat Gift Certificate';
    }

    public function getGiftCertificateFullNumberAttribute()
    {
        if (! empty($this->gift_certificate_year_issued) && ! empty($this->gift_certificate_number)) {
            return $this->gift_certificate_year_issued.'-'.$this->gift_certificate_number;
        } else {
            return null;
        }
    }

    public function getIsGiftCertificateRegistrationAttribute()
    {
        return isset($this->gift_certificate_number);
    }

    public function getOrderDescriptionAttribute()
    {
        if (empty($this->gift_certificate_full_number)) {
            return 'Squarespace Order #'.$this->order_number;
        } else {
            return 'Gift Certificate #'.$this->gift_certificate_full_number;
        }
    }

    public function getMobilePhoneFormattedAttribute()
    {
        $clean_phone = $this->format_phone($this->mobile_phone);

        return $clean_phone['phone_formatted'];
    }

    public function getCoupleMobilePhoneFormattedAttribute()
    {
        $clean_phone = $this->format_phone($this->couple_mobile_phone);

        return $clean_phone['phone_formatted'];
    }

    public function getHomePhoneFormattedAttribute()
    {
        $clean_phone = $this->format_phone($this->home_phone);

        return $clean_phone['phone_formatted'];
    }

    public function getCoupleHomePhoneFormattedAttribute()
    {
        $clean_phone = $this->format_phone($this->couple_home_phone);

        return $clean_phone['phone_formatted'];
    }

    public function getWorkPhoneFormattedAttribute()
    {
        $clean_phone = $this->format_phone($this->work_phone);

        return $clean_phone['phone_formatted'];
    }
}
