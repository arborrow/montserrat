@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $asset->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Asset</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('asset.update', [$asset->id]))->acceptsFiles()->open() }}
                {{ html()->hidden('id', $asset->id) }}
                <div class="form-group">
                    <h3 class="text-primary">General information</h3>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Name', 'name') }}
                            {{ html()->text('name', $asset->name)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Asset type', 'asset_type_id') }}
                            {{ html()->select('asset_type_id', $asset_types, $asset->asset_type_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Description', 'description') }}
                            {{ html()->textarea('description', $asset->description)->class('form-control')->rows(1) }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Picture of asset (max 10M):', 'asset_photo') }}
                            {{ html()->file('asset_photo') }}
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Manufacturer', 'manufacturer') }}
                            {{ html()->text('manufacturer', $asset->manufacturer)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Model', 'model') }}
                            {{ html()->text('model', $asset->model)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Serial number', 'serial_number') }}
                            {{ html()->text('serial_number', $asset->serial_number)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Year', 'year') }}
                            {{ html()->text('year', $asset->year)->class('form-control') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Location', 'location_id') }}
                            {{ html()->select('location_id', $locations, $asset->location_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Department', 'department_id') }}
                            {{ html()->select('department_id', $departments, $asset->department_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Parent', 'parent_id') }}
                            {{ html()->select('parent_id', $parents, $asset->parent_id)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Status', 'status') }}
                            {{ html()->text('status', $asset->status)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Remarks', 'remarks') }}
                            {{ html()->textarea('remarks', $asset->remarks)->class('form-control')->rows(1) }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Active:', 'is_active')->class('col-lg-2') }}
                            {{ html()->checkbox('is_active', $asset->is_active, 1)->class('col-lg-1') }}
                        </div>

                    </div>

                    <h3 class="text-primary">Service information</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Manufacturer', 'manufacturer_id') }}
                            {{ html()->select('manufacturer_id', $vendors, $asset->manufacturer_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Vendor', 'vendor_id') }}
                            {{ html()->select('vendor_id', $vendors, $asset->vendor_id)->class('form-control') }}
                        </div>
                    </div>

                    <h3 class="text-primary">Power specifications</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Power line voltage', 'power_line_voltage') }}
                            {{ html()->text('power_line_voltage', $asset->power_line_voltage)->class('form-control') }}
                            {{ html()->select('power_line_voltage_uom_id', $uoms_electric, $asset->power_line_voltage_uom_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Power phase voltage', 'power_phase_voltage') }}
                            {{ html()->text('power_phase_voltage', $asset->power_phase_voltage)->class('form-control') }}
                            {{ html()->select('power_phase_voltage_uom_id', $uoms_electric, $asset->power_phase_voltage_uom_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Power phases', 'power_phases') }}
                            {{ html()->text('power_phases', $asset->power_phases)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Power amps', 'power_amp') }}
                            {{ html()->text('power_amp', $asset->power_amp)->class('form-control') }}
                            {{ html()->select('power_amp_uom_id', $uoms_electric, $asset->power_amp_uom_id)->class('form-control') }}
                        </div>
                    </div>

                    <h3 class="text-primary">Physical specifications</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Length', 'length') }}
                            {{ html()->text('length', $asset->length)->class('form-control') }}
                            {{ html()->select('length_uom_id', $uoms_length, $asset->length_uom_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Width', 'width') }}
                            {{ html()->text('width', $asset->width)->class('form-control') }}
                            {{ html()->select('width_uom_id', $uoms_length, $asset->width_uom_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Height', 'height') }}
                            {{ html()->text('height', $asset->height)->class('form-control') }}
                            {{ html()->select('height_uom_id', $uoms_length, $asset->height_uom_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Weight', 'weight') }}
                            {{ html()->text('weight', $asset->weight)->class('form-control') }}
                            {{ html()->select('weight_uom_id', $uoms_weight, $asset->weight_uom_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Capacity', 'capacity') }}
                            {{ html()->text('capacity', $asset->capacity)->class('form-control') }}
                            {{ html()->select('capacity_uom_id', $uoms_capacity, $asset->capacity_uom_id)->class('form-control') }}
                        </div>
                    </div>

                    <h3 class="text-primary">Purchase info</h3>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Purchase date', 'purchase_date') }}
                            {{ html()->date('purchase_date', $asset->purchase_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Purchase price', 'purchase_price') }}
                            {{ html()->text('purchase_price', $asset->purchase_price)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Start date', 'start_date') }}
                            {{ html()->text('start_date', $asset->start_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('End date', 'end_date') }}
                            {{ html()->text('end_date', $asset->end_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Life expectancy', 'life_expectancy') }}
                            {{ html()->text('life_expectancy', $asset->life_expectancy)->class('form-control') }}
                            {{ html()->select('life_expectancy_uom_id', $uoms_time, $asset->life_expectancy_uom_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Replacement', 'replacement_id') }}
                            {{ html()->select('replacement_id', $parents, $asset->replacement_id)->class('form-control') }}
                        </div>
                    </div>
                    <h3 class="text-primary">Warranty info</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Warranty start date', 'warranty_start_date') }}
                            {{ html()->text('warranty_start_date', $asset->warranty_start_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Warranty end date', 'warranty_end_date') }}
                            {{ html()->text('warranty_end_date', $asset->warranty_end_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                    </div>

                    <h3 class="text-primary">Depreciation info</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation start date', 'depreciation_start_date') }}
                            {{ html()->text('depreciation_start_date', $asset->depreciation_start_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation end date', 'depreciation_end_date') }}
                            {{ html()->text('depreciation_end_date', $asset->depreciation_end_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation type', 'depreciation_type_id') }}
                            {{ html()->select('depreciation_type_id', $depreciation_types, $asset->depreciation_type_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation rate', 'depreciation_rate') }}
                            {{ html()->text('depreciation_rate', $asset->depreciation_rate)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation value', 'depreciation_value') }}
                            {{ html()->text('depreciation_value', $asset->depreciation_value)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation time', 'depreciation_time') }}
                            {{ html()->text('depreciation_time', $asset->depreciation_time)->class('form-control') }}
                            {{ html()->select('depreciation_time_uom_id', $uoms_time, $asset->depreciation_time_uom_id)->class('form-control') }}
                        </div>
                    </div>
                    <h3 class="text-primary">Attachments</h3>
                    <div class="row">
                        <div class="col-lg-4" id="attachments">
                            {{ html()->label('Attachment (max 20M): ', 'attachment') }}
                            {{ html()->file('attachment')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Description: (max 200)', 'attachment_description') }}
                            {{ html()->text('attachment_description')->class('form-control') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
