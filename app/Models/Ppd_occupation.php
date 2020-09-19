<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Ppd_occupation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
}
