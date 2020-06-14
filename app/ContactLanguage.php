<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactLanguage extends Model
{
    use SoftDeletes;
    protected $table = 'contact_languages';
}
