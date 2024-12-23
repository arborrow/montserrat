<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

// imported table from PPD - not actively used in Polanco - stored for archival purposes
//use Illuminate\Database\Eloquent\SoftDeletes;

class Donor extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    //use SoftDeletes;
    protected $table = 'Donors';

    // protected $primaryKey = 'donor_id';
    public $timestamps = false;

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, 'donor_id', 'donor_id');
    }
}
