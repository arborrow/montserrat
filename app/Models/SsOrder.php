<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class SsOrder extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'ss_order';

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


}
