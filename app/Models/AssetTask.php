<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AssetTask extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'asset_task';
    protected $dates = ['start_date', 'scheduled_until_date'];

    // relations
    public function asset()
    {
        return $this->BelongsTo(Asset::class, 'asset_id');
    }

    public function jobs()
    {
        return $this->hasMany(AssetJob::class, 'asset_task_id', 'id');
    }
}
