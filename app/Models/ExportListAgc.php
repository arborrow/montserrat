<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

#[Table('export_list_agc')]
class ExportListAgc extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

}
