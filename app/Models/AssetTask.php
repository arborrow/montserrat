<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AssetTask extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'asset_task';

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'scheduled_until_date' => 'datetime',
        ];
    }

    // relations
    public function asset()
    {
        return $this->BelongsTo(Asset::class, 'asset_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(AssetJob::class, 'asset_task_id', 'id');
    }

    public function getAssetNameAttribute()
    {
        if (isset($this->asset->name)) {
            return $this->asset->name;
        } else {
            return 'N/A';
        }
    }

    public function getScheduledTimeAttribute()
    {
        if (isset($this->frequency_time)) {
            return $this->frequency_time;
        } else {
            return $this->start_date->toTimeString();
        }
    }

    public function getScheduledDayAttribute()
    {
        if (isset($this->frequency_day)) {
            return $this->frequency_day;
        } else {
            return $this->start_date->day;
        }
    }

    public function getScheduledDowAttribute()
    {
        if (isset($this->frequency_day)) {
            return $this->frequency_day;
        } else {
            return $this->start_date->dayOfWeek;
        }
    }

    public function getScheduledMonthAttribute()
    {
        if (isset($this->frequency_month)) {
            return $this->frequency_month;
        } else {
            return $this->start_date->month;
        }
    }
}
