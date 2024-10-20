<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AssetType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'asset_type';

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    public function parent_asset_type()
    {
        return $this->hasOne(self::class, 'id', 'parent_asset_type_id');
    }

    public function getParentLabelAttribute()
    {
        if (isset($this->parent_asset_type->label)) {
            return $this->parent_asset_type->label;
        } else {
            return 'N/A';
        }
    }

    public function getParentNameAttribute()
    {
        if (isset($this->parent_asset_type->name)) {
            return $this->parent_asset_type->name;
        } else {
            return 'N/A';
        }
    }
}
