<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;
    protected $table = 'asset';
    protected $dates = ['start_date', 'end_date', 'purchase_date','warranty_start_date', 'warranty_end_date','depreciation_start_date', 'depreciation_end_date'];

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    public function parent()
    {
        return $this->hasOne(Asset::class, 'id', 'parent_id');
    }
    public function asset_type()
    {
        return $this->hasOne(AssetType::class, 'id', 'asset_type_id');
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    // normally would name simply manufacturer; however, there is an existing field with that name in it
    public function manufacturer_contact()
    {
        return $this->hasOne(Contact::class, 'id', 'manufacturer_id');
    }

    public function vendor()
    {
        return $this->hasOne(Contact::class, 'id', 'vendor_id');
    }

    public function power_line_voltage_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'power_line_voltage_uom_id');
    }

    public function power_phase_voltage_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'power_phase_voltage_uom_id');
    }

    public function power_amp_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'power_amp_uom_id');
    }

    public function length_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'length_uom_id');
    }

    public function width_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'width_uom_id');
    }

    public function height_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'height_uom_id');
    }

    public function weight_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'weight_uom_id');
    }

    public function life_expectancy_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'life_expectancy_uom_id');
    }

    public function depreciation_time_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'depreciation_time_uom_id');
    }

    public function capacity_uom()
    {
        return $this->hasOne(Uom::class, 'id', 'capacity_uom_id');
    }

    public function getAssetTypeNameAttribute() {
        if (isset($this->asset_type->name)) {
            return $this->asset_type->name;
        } else {
            return 'N/A';
        }
    }

    public function getDepartmentNameAttribute() {
        if (isset($this->department->name)) {
            return $this->department->name;
        } else {
            return 'N/A';
        }
    }

    public function getLocationNameAttribute() {
        if (isset($this->location->name)) {
            return $this->location->name;
        } else {
            return 'N/A';
        }
    }

    public function getManufacturerContactNameLinkAttribute() {
        if (isset($this->manufacturer_contact->organization_name)) {
            return '<a href ="'.$this->manufacturer_contact->contact_url.'">'.$this->manufacturer_contact->organization_name.'</a>';
        } else {
            return 'N/A';
        }
    }

    public function getParentNameAttribute() {
        if (isset($this->parent->name)) {
            return $this->parent->name;
        } else {
            return 'N/A';
        }
    }

    public function getVendorNameLinkAttribute() {
        if (isset($this->vendor->organization_name)) {
            return '<a href ="'.$this->vendor->contact_url.'">'.$this->vendor->organization_name.'</a>';
        } else {
            return 'N/A';
        }
    }

    public function getCapacityUomNameAttribute() {
        if (isset($this->capacity_uom->unit_name)) {
            return $this->capacity_uom->unit_name;
        } else {
            return ;
        }
    }

    public function getPowerLineVoltageUomNameAttribute() {
        if (isset($this->power_line_voltage_uom->unit_name)) {
            return $this->power_line_voltage_uom->unit_name;
        } else {
            return ;
        }
    }

    public function getPowerPhaseVoltageUomNameAttribute() {
        if (isset($this->power_phase_voltage_uom->unit_name)) {
            return $this->power_phase_voltage_uom->unit_name;
        } else {
            return ;
        }
    }


    public function getPowerAmpUomNameAttribute() {
        if (isset($this->power_amp_uom->unit_name)) {
            return $this->power_amp_uom->unit_name;
        } else {
            return ;
        }
    }

    public function getLengthUomNameAttribute() {
        if (isset($this->length_uom->unit_name)) {
            return $this->length_uom->unit_name;
        } else {
            return ;
        }
    }

    public function getWidthUomNameAttribute() {
        if (isset($this->width_uom->unit_name)) {
            return $this->width_uom->unit_name;
        } else {
            return ;
        }
    }
    public function getHeightUomNameAttribute() {
        if (isset($this->height_uom->unit_name)) {
            return $this->height_uom->unit_name;
        } else {
            return ;
        }
    }
    public function getWeightUomNameAttribute() {
        if (isset($this->weight_uom->unit_name)) {
            return $this->weight_uom->unit_name;
        } else {
            return ;
        }
    }
    public function getLifeExpectancyUomNameAttribute() {
        if (isset($this->life_expectancy_uom->unit_name)) {
            return $this->life_expectancy_uom->unit_name;
        } else {
            return ;
        }
    }
    public function getDepreciationTimeUomNameAttribute() {
        if (isset($this->depreciation_time_uom->unit_name)) {
            return $this->depreciation_time_uom->unit_name;
        } else {
            return ;
        }
    }

}
