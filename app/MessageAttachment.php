<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageAttachment extends Model
{
    use SoftDeletes;
    protected $table = 'message_attachments';
    protected $fillable = ['mailgun_id', 'mailgun_timestamp', 'attachment_id', 'url', 'content_type'];
}
