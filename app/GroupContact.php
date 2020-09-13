<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class GroupContact extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'group_contact';
    protected $fillable = ['contact_id', 'group_id', 'status'];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function getContactSortNameAttribute()
    {
        $sort_name = empty($this->contact->sort_name) ? null : $this->contact->sort_name;
        return $sort_name;
    }

    public function getGroupNameAttribute()
    {
        $group_name = empty($this->group->name) ? null : $this->group->name;
        return $group_name;
    }
}
