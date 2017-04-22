<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class MessageAttachment extends Model
{
    use SoftDeletes;
    protected $table = 'message_attachments';
    protected $fillable = ['mailgun_id','mailgun_timestamp','attachment_id','url','content_type'];
}
