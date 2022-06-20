<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\PhoneTrait;


class SquarespaceContribution extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use PhoneTrait;

    protected $table = 'squarespace_contribution';

    protected $fillable = ['message_id'];

    public function message()
    {
        return $this->hasOne(Message::class, 'id', 'message_id');
    }

    public function event()
    {
        return $this->hasOne(Retreat::class, 'id', 'event_id');
    }

    public function donor()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function donation()
    {
        return $this->hasOne(Donation::class, 'donation_id', 'donation_id');

    }

    public function getPhoneFormattedAttribute() {
        $clean_phone = $this->format_phone($this->phone);
        return $clean_phone['phone_formatted'];
    }



}
