<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Note extends Model
{
    use SoftDeletes;
    protected $table = 'note';
    protected $fillable = ['entity_table','entity_id','note','contact_id','subject','privacy'];
}
