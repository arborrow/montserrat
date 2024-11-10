<?php

namespace App\Models;

use App\Traits\PhoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SquarespaceContribution extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use PhoneTrait;
    use SoftDeletes;

    protected $table = 'squarespace_contribution';

    protected $fillable = ['message_id'];

    public function message(): HasOne
    {
        return $this->hasOne(Message::class, 'id', 'message_id');
    }

    public function event(): HasOne
    {
        return $this->hasOne(Retreat::class, 'id', 'event_id');
    }

    public function donor(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function donation(): HasOne
    {
        return $this->hasOne(Donation::class, 'donation_id', 'donation_id');
    }

    public function getPhoneFormattedAttribute()
    {
        $clean_phone = $this->format_phone($this->phone);

        return $clean_phone['phone_formatted'];
    }

    public function getFullDescriptionAttribute()
    {
        $retreat = (isset($this->idnumber) && $this->idnumber != '') ? ('#'.$this->idnumber.':'.$this->retreat_description) : null;
        $fund = (isset($this->fund)) ? $this->fund : null;
        $description = (isset($retreat)) ? $retreat : $fund;

        return $this->name.' - '.'$'.number_format($this->amount, 2).' - '.$description.' ('.$this->created_at->format('m-d-Y').')';
    }
}
