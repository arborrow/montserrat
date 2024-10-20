<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AssetJob extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'asset_job';

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'scheduled_date' => 'datetime',
        ];
    }

    // relations
    public function asset_task()
    {
        return $this->belongsTo(AssetTask::class, 'asset_task_id');
    }

    public function assigned_to()
    {
        return $this->belongsTo(Contact::class, 'assigned_to_id', 'id');
    }

    public function getAssignedSortNameAttribute()
    {
        if (isset($this->assigned_to->sort_name)) {
            return $this->assigned_to->sort_name;
        } else {
            return 'Unassigned';
        }
    }

    public function getAssignedContactUrlAttribute()
    {
        if (isset($this->assigned_to->contact_url)) {
            return $this->assigned_to->contact_url;
        } else {
            return 'Unassigned';
        }
    }
}
