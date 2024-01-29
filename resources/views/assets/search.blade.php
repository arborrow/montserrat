@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Assets</strong></h1>
        </div>

        {{ html()->form('GET', route('assets.results', ))->class('form-horizontal')->open() }}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{{ html()->input('image', 'btnSave')->class('btn btn-outline-dark pull-right')->attribute('src', asset('images/submit.png')) }}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <h3 class="text-primary">General information</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Name', 'name') }}
                            {{ html()->text('name')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Asset type', 'asset_type_id') }}
                            {{ html()->select('asset_type_id', $asset_types)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Description', 'description') }}
                            {{ html()->textarea('description')->class('form-control')->rows(1) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Manufacturer', 'manufacturer') }}
                            {{ html()->text('manufacturer')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Model', 'model') }}
                            {{ html()->text('model')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Serial number', 'serial_number') }}
                            {{ html()->text('serial_number')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Year', 'year') }}
                            {{ html()->text('year')->class('form-control') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Location', 'location_id') }}
                            {{ html()->select('location_id', $locations)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Department', 'department_id') }}
                            {{ html()->select('department_id', $departments)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Parent', 'parent_id') }}
                            {{ html()->select('parent_id', $parents)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Status', 'status') }}
                            {{ html()->text('status')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Remarks', 'remarks') }}
                            {{ html()->textarea('remarks')->class('form-control')->rows(1) }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Active', 'is_active') }}
                            {{ html()->select('is_active', array('' => 'N/A', '1' => 'Yes', '0' => 'No'))->class('form-control') }}
                        </div>

                    </div>

                    <h3 class="text-primary">Service information</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Manufacturer', 'manufacturer_id') }}
                            {{ html()->select('manufacturer_id', $vendors)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Vendor', 'vendor_id') }}
                            {{ html()->select('vendor_id', $vendors)->class('form-control') }}
                        </div>
                    </div>

                    <h3 class="text-primary">Power specifications</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Power line voltage', 'power_line_voltage') }}
                            {{ html()->text('power_line_voltage')->class('form-control') }}
                            {{ html()->select('power_line_voltage_uom_id', $uoms_electric)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Power phase voltage', 'power_phase_voltage') }}
                            {{ html()->text('power_phase_voltage')->class('form-control') }}
                            {{ html()->select('power_phase_voltage_uom_id', $uoms_electric)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Power phases', 'power_phases') }}
                            {{ html()->text('power_phases')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Power amps', 'power_amp') }}
                            {{ html()->text('power_amp')->class('form-control') }}
                            {{ html()->select('power_amp_uom_id', $uoms_electric)->class('form-control') }}
                        </div>
                    </div>

                    <h3 class="text-primary">Physical specifications</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Length', 'length') }}
                            {{ html()->text('length')->class('form-control') }}
                            {{ html()->select('length_uom_id', $uoms_length)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Width', 'width') }}
                            {{ html()->text('width')->class('form-control') }}
                            {{ html()->select('width_uom_id', $uoms_length)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Height', 'height') }}
                            {{ html()->text('height')->class('form-control') }}
                            {{ html()->select('height_uom_id', $uoms_length)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Weight', 'weight') }}
                            {{ html()->text('weight')->class('form-control') }}
                            {{ html()->select('weight_uom_id', $uoms_weight)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Capacity', 'capacity') }}
                            {{ html()->text('capacity')->class('form-control') }}
                            {{ html()->select('capacity_uom_id', $uoms_capacity)->class('form-control') }}
                        </div>
                    </div>

                    <h3 class="text-primary">Purchase info</h3>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Purchase date', 'purchase_date') }}
                            {{ html()->date('purchase_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Purchase price', 'purchase_price') }}
                            {{ html()->text('purchase_price')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Start date', 'start_date') }}
                            {{ html()->text('start_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('End date', 'end_date') }}
                            {{ html()->text('end_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Life expectancy', 'life_expectancy') }}
                            {{ html()->text('life_expectancy')->class('form-control') }}
                            {{ html()->select('life_expectancy_uom_id', $uoms_time)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Replacement', 'replacement_id') }}
                            {{ html()->select('replacement_id', $parents)->class('form-control') }}
                        </div>
                    </div>
                    <h3 class="text-primary">Warranty info</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Warranty start date', 'warranty_start_date') }}
                            {{ html()->text('warranty_start_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Warranty end date', 'warranty_end_date') }}
                            {{ html()->text('warranty_end_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                    </div>

                    <h3 class="text-primary">Depreciation info</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation start date', 'depreciation_start_date') }}
                            {{ html()->text('depreciation_start_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation end date', 'depreciation_end_date') }}
                            {{ html()->text('depreciation_end_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation type', 'depreciation_type_id') }}
                            {{ html()->select('depreciation_type_id', $depreciation_types)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation rate', 'depreciation_rate') }}
                            {{ html()->text('depreciation_rate')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation value', 'depreciation_value') }}
                            {{ html()->text('depreciation_value')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Depreciation time', 'depreciation_time') }}
                            {{ html()->text('depreciation_time')->class('form-control') }}
                            {{ html()->select('depreciation_time_uom_id', $uoms_time)->class('form-control') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
</div>

@stop
