<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    protected $table = 'group';

    public function members()
    {
        return $this->hasMany(GroupContact::class, 'group_id', 'id');
    }
}
