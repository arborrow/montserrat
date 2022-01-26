<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AssetJob extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'asset_job';

    protected $dates = ['start_date', 'end_date', 'scheduled_date'];

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
