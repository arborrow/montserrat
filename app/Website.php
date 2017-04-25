<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{
    //
    use SoftDeletes;
    protected $table = 'website';
    protected $fillable =  ['contact_id', 'url', 'website_type'];
    
    public function owner()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
}
