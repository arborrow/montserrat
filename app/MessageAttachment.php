<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageAttachment extends Model
{
    use SoftDeletes;
    protected $fillable = ['mailgun_id', 'mailgun_timestamp', 'attachment_id', 'url', 'content_type'];
}
