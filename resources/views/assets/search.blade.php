@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Assets</strong></h1>
        </div>

        {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal', 'route' => ['assets.results']]) !!}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{!! Form::image('images/submit.png','btnSave',['class' => 'btn btn-outline-dark pull-right']) !!}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <h3 class="text-primary">General information</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('asset_type_id', 'Asset type') !!}
                            {!! Form::select('asset_type_id', $asset_types, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', NULL, ['class' => 'form-control', 'rows' => 1]) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            {!! Form::label('manufacturer', 'Manufacturer') !!}
                            {!! Form::text('manufacturer', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('model', 'Model') !!}
                            {!! Form::text('model', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('serial_number', 'Serial number') !!}
                            {!! Form::text('serial_number', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('year', 'Year') !!}
                            {!! Form::text('year', NULL , ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3">
                            {!! Form::label('location_id', 'Location') !!}
                            {!! Form::select('location_id', $locations, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('department_id', 'Department') !!}
                            {!! Form::select('department_id', $departments, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('parent_id', 'Parent') !!}
                            {!! Form::select('parent_id', $parents, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {!! Form::label('status', 'Status') !!}
                            {!! Form::text('status', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('remarks', 'Remarks') !!}
                            {!! Form::textarea('remarks', NULL, ['class' => 'form-control', 'rows' => 1]) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('is_active', 'Active') !!}
                            {!! Form::select('is_active', array('' => 'N/A', '1' => 'Yes', '0' => 'No'), NULL, ['class' => 'form-control']) !!}
                        </div>

                    </div>

                    <h3 class="text-primary">Service information</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('manufacturer_id', 'Manufacturer') !!}
                            {!! Form::select('manufacturer_id', $vendors, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('vendor_id', 'Vendor') !!}
                            {!! Form::select('vendor_id', $vendors, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <h3 class="text-primary">Power specifications</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('power_line_voltage', 'Power line voltage') !!}
                            {!! Form::text('power_line_voltage', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('power_line_voltage_uom_id', $uoms_electric, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('power_phase_voltage', 'Power phase voltage') !!}
                            {!! Form::text('power_phase_voltage', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('power_phase_voltage_uom_id', $uoms_electric, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('power_phases', 'Power phases') !!}
                            {!! Form::text('power_phases', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('power_amp', 'Power amps') !!}
                            {!! Form::text('power_amp', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('power_amp_uom_id', $uoms_electric, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <h3 class="text-primary">Physical specifications</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('length', 'Length') !!}
                            {!! Form::text('length', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('length_uom_id', $uoms_length, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('width', 'Width') !!}
                            {!! Form::text('width', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('width_uom_id', $uoms_length, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('height', 'Height') !!}
                            {!! Form::text('height', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('height_uom_id', $uoms_length, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('weight', 'Weight') !!}
                            {!! Form::text('weight', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('weight_uom_id', $uoms_weight, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('capacity', 'Capacity') !!}
                            {!! Form::text('capacity', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('capacity_uom_id', $uoms_capacity, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <h3 class="text-primary">Purchase info</h3>
                    <div class="row">
                        <div class="col-lg-3">
                            {!! Form::label('purchase_date', 'Purchase date') !!}
                            {!! Form::date('purchase_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('purchase_price', 'Purchase price') !!}
                            {!! Form::text('purchase_price', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('start_date', 'Start date') !!}
                            {!! Form::text('start_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('end_date', 'End date') !!}
                            {!! Form::text('end_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('life_expectancy', 'Life expectancy') !!}
                            {!! Form::text('life_expectancy', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('life_expectancy_uom_id', $uoms_time, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('replacement_id', 'Replacement') !!}
                            {!! Form::select('replacement_id', $parents, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <h3 class="text-primary">Warranty info</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('warranty_start_date', 'Warranty start date') !!}
                            {!! Form::text('warranty_start_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('warranty_end_date', 'Warranty end date') !!}
                            {!! Form::text('warranty_end_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                    </div>

                    <h3 class="text-primary">Depreciation info</h3>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('depreciation_start_date', 'Depreciation start date') !!}
                            {!! Form::text('depreciation_start_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('depreciation_end_date', 'Depreciation end date') !!}
                            {!! Form::text('depreciation_end_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('depreciation_type_id', 'Depreciation type') !!}
                            {!! Form::select('depreciation_type_id', $depreciation_types, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('depreciation_rate', 'Depreciation rate') !!}
                            {!! Form::text('depreciation_rate', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('depreciation_value', 'Depreciation value') !!}
                            {!! Form::text('depreciation_value', NULL , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('depreciation_time', 'Depreciation time') !!}
                            {!! Form::text('depreciation_time', NULL , ['class' => 'form-control']) !!}
                            {!! Form::select('depreciation_time_uom_id', $uoms_time, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@stop
