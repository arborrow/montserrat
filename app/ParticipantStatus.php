<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipantStatus extends Model
{
    use SoftDeletes;
    protected $table = 'participant_status_type';
}
