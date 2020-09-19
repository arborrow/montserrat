<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Website extends Model implements Auditable
{
    use HasFactory;

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'website';
    protected $fillable = ['contact_id', 'url', 'website_type'];

    public function owner()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
}
