<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Message extends Model
{
    use SoftDeletes;

    protected $table = 'messages';
    protected $dates = ['mailgun_timestamp', 'created_at', 'updated_at', 'disabled_at', 'deleted_at'];  //

    protected $fillable = ['mailgun_id','mailgun_timestamp','storage_url','from','to','subject','from_id','to_id','is_processed'];
}
