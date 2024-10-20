<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Asset extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'asset';

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'purchase_date' => 'datetime',
            'warranty_start_date' => 'datetime',
            'warranty_end_date' => 'datetime',
            'depreciation_start_date' => 'datetime',
            'depreciation_end_date' => 'datetime',
        ];
    }

    // relations

    public function tasks(): HasMany
    {
        return $this->hasMany(AssetTask::class, 'asset_id', 'id');
    }

    public function jobs(): HasManyThrough
    {
        return $this->hasManyThrough(AssetJob::class, AssetTask::class, 'asset_id', 'asset_task_id', 'id', 'id');
    }

    public function asset_type(): HasOne
    {
        return $this->hasOne(AssetType::class, 'id', 'asset_type_id');
    }

    public function capacity_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'capacity_uom_id');
    }

    public function depreciation_time_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'depreciation_time_uom_id');
    }

    public function department(): HasOne
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function height_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'height_uom_id');
    }

    public function length_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'length_uom_id');
    }

    public function life_expectancy_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'life_expectancy_uom_id');
    }

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    // normally would name simply manufacturer; however, there is an existing field with that name in it
    public function manufacturer_contact(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'manufacturer_id');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function power_amp_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'power_amp_uom_id');
    }

    public function power_line_voltage_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'power_line_voltage_uom_id');
    }

    public function power_phase_voltage_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'power_phase_voltage_uom_id');
    }

    public function replacement(): HasOne
    {
        return $this->hasOne(self::class, 'id', 'replacement_id');
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'vendor_id');
    }

    public function websites(): HasMany
    {
        return $this->hasMany(Website::class, 'asset_id', 'id');
    }

    public function weight_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'weight_uom_id');
    }

    public function width_uom(): HasOne
    {
        return $this->hasOne(Uom::class, 'id', 'width_uom_id');
    }

    //attributes
    public function getAssetTypeNameAttribute()
    {
        if (isset($this->asset_type->name)) {
            return $this->asset_type->name;
        } else {
            return 'N/A';
        }
    }

    public function getDepartmentNameAttribute()
    {
        if (isset($this->department->name)) {
            return $this->department->name;
        } else {
            return 'N/A';
        }
    }

    public function getLocationNameAttribute()
    {
        if (isset($this->location->name)) {
            return $this->location->name;
        } else {
            return 'N/A';
        }
    }

    public function getManufacturerContactNameLinkAttribute()
    {
        if (isset($this->manufacturer_contact->organization_name)) {
            return '<a href ="'.$this->manufacturer_contact->contact_url.'">'.$this->manufacturer_contact->organization_name.'</a>';
        } else {
            return 'N/A';
        }
    }

    public function getParentNameAttribute()
    {
        if (isset($this->parent->name)) {
            return $this->parent->name;
        } else {
            return 'N/A';
        }
    }

    public function getReplacementNameAttribute()
    {
        if (isset($this->replacement->name)) {
            return $this->replacement->name;
        } else {
            return 'N/A';
        }
    }

    public function getVendorNameLinkAttribute()
    {
        if (isset($this->vendor->organization_name)) {
            return '<a href ="'.$this->vendor->contact_url.'">'.$this->vendor->organization_name.'</a>';
        } else {
            return 'N/A';
        }
    }

    public function getCapacityUomNameAttribute()
    {
        if (isset($this->capacity_uom->unit_name)) {
            return $this->capacity_uom->unit_name;
        } else {
            return;
        }
    }

    public function getPowerLineVoltageUomNameAttribute()
    {
        if (isset($this->power_line_voltage_uom->unit_name)) {
            return $this->power_line_voltage_uom->unit_name;
        } else {
            return;
        }
    }

    public function getPowerPhaseVoltageUomNameAttribute()
    {
        if (isset($this->power_phase_voltage_uom->unit_name)) {
            return $this->power_phase_voltage_uom->unit_name;
        } else {
            return;
        }
    }

    public function getPowerAmpUomNameAttribute()
    {
        if (isset($this->power_amp_uom->unit_name)) {
            return $this->power_amp_uom->unit_name;
        } else {
            return;
        }
    }

    public function getLengthUomNameAttribute()
    {
        if (isset($this->length_uom->unit_name)) {
            return $this->length_uom->unit_name;
        } else {
            return;
        }
    }

    public function getWidthUomNameAttribute()
    {
        if (isset($this->width_uom->unit_name)) {
            return $this->width_uom->unit_name;
        } else {
            return;
        }
    }

    public function getHeightUomNameAttribute()
    {
        if (isset($this->height_uom->unit_name)) {
            return $this->height_uom->unit_name;
        } else {
            return;
        }
    }

    public function getWeightUomNameAttribute()
    {
        if (isset($this->weight_uom->unit_name)) {
            return $this->weight_uom->unit_name;
        } else {
            return;
        }
    }

    public function getLifeExpectancyUomNameAttribute()
    {
        if (isset($this->life_expectancy_uom->unit_name)) {
            return $this->life_expectancy_uom->unit_name;
        } else {
            return;
        }
    }

    public function getDepreciationTimeUomNameAttribute()
    {
        if (isset($this->depreciation_time_uom->unit_name)) {
            return $this->depreciation_time_uom->unit_name;
        } else {
            return;
        }
    }

    public function getStartDayAttribute()
    {
        if (isset($this->start_date)) {
            return $this->start_date->format('m-d-Y');
        } else {
            return;
        }
    }

    public function getEndDayAttribute()
    {
        if (isset($this->end_date)) {
            return $this->end_date->format('m-d-Y');
        } else {
            return;
        }
    }

    public function getPurchaseDayAttribute()
    {
        if (isset($this->purchase_date)) {
            return $this->purchase_date->format('m-d-Y');
        } else {
            return;
        }
    }

    public function getWarrantyStartDayAttribute()
    {
        if (isset($this->warranty_start_date)) {
            return $this->warranty_start_date->format('m-d-Y');
        } else {
            return;
        }
    }

    public function getWarrantyEndDayAttribute()
    {
        if (isset($this->warranty_end_date)) {
            return $this->warranty_end_date->format('m-d-Y');
        } else {
            return;
        }
    }

    public function getDepreciationStartDayAttribute()
    {
        if (isset($this->depreciation_start_date)) {
            return $this->depreciation_start_date->format('m-d-Y');
        } else {
            return;
        }
    }

    public function getDepreciationEndDayAttribute()
    {
        if (isset($this->depreciation_end_date)) {
            return $this->depreciation_end_date->format('m-d-Y');
        } else {
            return;
        }
    }

    //scopes
    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    public function scopeFiltered($query, $filters)
    {
        foreach ($filters->query as $filter => $value) {
            if ($filter == 'name' && ! empty($value)) {
                $query->where($filter, 'like', '%'.$value.'%');
            }
            if ($filter == 'asset_type_id' && ! empty($value) && $value > 0) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'description' && ! empty($value)) {
                $query->where($filter, 'like', '%'.$value.'%');
            }
            if ($filter == 'manufacturer' && ! empty($value)) {
                $query->where($filter, 'like', '%'.$value.'%');
            }
            if ($filter == 'model' && ! empty($value)) {
                $query->where($filter, 'like', '%'.$value.'%');
            }
            if ($filter == 'serial_number' && ! empty($value)) {
                $query->where($filter, 'like', '%'.$value.'%');
            }
            if ($filter == 'year' && ! empty($value)) {
                $query->where($filter, 'like', '%'.$value.'%');
            }
            if ($filter == 'location_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'department_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'parent_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'manufacturer_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'vendor_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'status' && ! empty($value)) {
                $query->where($filter, 'like', '%'.$value.'%');
            }
            if ($filter == 'remarks' && ! empty($value)) {
                $query->where($filter, 'like', '%'.$value.'%');
            }
            if ($filter == 'is_active' && isset($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'power_line_voltage' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'power_line_voltage_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'power_phase_voltage' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'power_phase_voltage_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'power_phases' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }

            if ($filter == 'power_amp' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'power_amp_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'length' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'length_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'width' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'width_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'height' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'height_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'weight' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'weight_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'capacity' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'capacity_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'purchase_date' && ! empty($value)) {
                $purchase_date = Carbon::parse($value);
                $query->where('purchase_date', '<=', $purchase_date);
            }
            if ($filter == 'purchase_price' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'life_expectancy' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'life_expectancy_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'start_date' && ! empty($value)) {
                $start_date = Carbon::parse($value);
                $query->where('start_date', '<=', $start_date);
            }
            if ($filter == 'end_date' && ! empty($value)) {
                $end_date = Carbon::parse($value);
                $query->where('end_date', '<=', $end_date);
            }
            if ($filter == 'replacement_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }

            if ($filter == 'warranty_start_date' && ! empty($value)) {
                $warranty_start_date = Carbon::parse($value);
                $query->where('warranty_start_date', '<=', $warranty_start_date);
            }
            if ($filter == 'warranty_end_date' && ! empty($value)) {
                $warranty_end_date = Carbon::parse($value);
                $query->where('warranty_end_date', '<=', $warranty_end_date);
            }
            if ($filter == 'depreciation_start_date' && ! empty($value)) {
                $depreciation_start_date = Carbon::parse($value);
                $query->where('depreciation_start_date', '<=', $depreciation_start_date);
            }
            if ($filter == 'depreciation_end_date' && ! empty($value)) {
                $depreciation_end_date = Carbon::parse($value);
                $query->where('depreciation_end_date', '<=', $depreciation_end_date);
            }
            if ($filter == 'depreciation_type_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
            if ($filter == 'depreciation_rate' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'depreciation_value' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'depreciation_time' && ! empty($value)) {
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
            if ($filter == 'depreciation_time_uom_id' && ! empty($value)) {
                $query->where($filter, '=', $value);
            }
        }

        return $query;
    }
}
