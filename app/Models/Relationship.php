<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Relationship extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'relationship';

    protected $fillable = ['contact_id_a', 'contact_id_b', 'relationship_type_id', 'is_active', 'description'];

    protected $appends = ['contact_a_address', 'contact_b_address'];

    public function relationship_type(): HasOne
    {
        return $this->hasOne(RelationshipType::class, 'id', 'relationship_type_id');
    }

    public function contact_a(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id_a');
    }

    public function contact_b(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id_b');
    }

    public function getContactADisplayNameAttribute()
    {
        if (isset($this->contact_a) && $this->contact_a > 0) {
            //default is individual person
            $display_name = '<a href="'.$this->contact_a->id.'">'.$this->contact_a->display_name.'</a>';
            //diocese
            if ($this->contact_a->contact_type == config('polanco.contact_type.organization') && $this->contact_a->subcontact_type == config('polanco.contact_type.diocese')) {
                $display_name = '<a href="../diocese/'.$this->contact_a->id.'">'.$this->contact_a->display_name.'</a>';
            }
            //parish
            if ($this->contact_a->contact_type == config('polanco.contact_type.organization') && $this->contact_a->subcontact_type == config('polanco.contact_type.parish')) {
                $display_name = '<a href="../parish/'.$this->contact_a->id.'">'.$this->contact_a->display_name.'</a>';
            }

            return $display_name;
        } else {
            return;
        }
    }

    public function getContactBDisplayNameAttribute()
    {
        if (isset($this->contact_b) && $this->contact_b > 0) {
            //default is individual person
            $display_name = '<a href="'.$this->contact_b->id.'">'.$this->contact_b->display_name.'</a>';
            //diocese
            if ($this->contact_b->contact_type == config('polanco.contact_type.organization') && $this->contact_b->subcontact_type == config('polanco.contact_type.diocese')) {
                $display_name = '<a href="../diocese'.$this->contact_b->id.'">'.$this->contact_b->display_name.'</a>';
            }
            //parish
            if ($this->contact_b->contact_type == config('polanco.contact_type.organization') && $this->contact_b->subcontact_type == config('polanco.contact_type.parish')) {
                $display_name = '<a href="../parish/'.$this->contact_b->id.'">'.$this->contact_b->display_name.'</a>';
            }

            return $display_name;
        } else {
            return;
        }
    }

    /*
    * returns former if is_active is 0 to distinguish between current/active relationships
    */
    public function getIsFormerAttribute()
    {
        if (! $this->is_active) {
            return 'former';
        } else {
            return null;
        }
    }

    public function getContactAAddressAttribute()
    {
        if (isset($this->contact_a->address_primary->street_address)) {
            return $this->contact_a->address_primary->street_address;
        } else {
            return 'No A Address';
        }
    }

    public function getContactBAddressAttribute()
    {
        if (isset($this->contact_b->address_primary->street_address)) {
            return $this->contact_b->address_primary->street_address;
        } else {
            return 'No B Address';
        }
    }
}
