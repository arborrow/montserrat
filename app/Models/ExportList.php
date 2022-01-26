<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ExportList extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'export_list';
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'last_run_date' => 'datetime',
        'next_scheduled_date' => 'datetime',
    ];
}
