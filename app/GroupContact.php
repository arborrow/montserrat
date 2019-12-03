<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupContact extends Model
{
    use SoftDeletes;
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
        return $this->contact->sort_name;
    }
}
