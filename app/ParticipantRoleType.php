<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipantRoleType extends Model
{
    use SoftDeletes;
    protected $table = 'participant_role_type';
}
