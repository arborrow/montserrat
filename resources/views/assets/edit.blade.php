@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit: {!! $asset->name !!}</h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <h2>Asset</h2>
            </div>
            <div class="col-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['asset.update', $asset->id],'enctype'=>'multipart/form-data']) !!}
                {!! Form::hidden('id', $asset->id) !!}
                <div class="form-group">
                    <h3 class="text-primary">General information</h3>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', $asset->name , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('asset_type_id', 'Asset type') !!}
                            {!! Form::select('asset_type_id', $asset_types, $asset->asset_type_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', $asset->description, ['class' => 'form-control', 'rows' => 1]) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('asset_photo', 'Picture of asset (max 10M):')  !!}
                            {!! Form::file('asset_photo'); !!}
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('manufacturer', 'Manufacturer') !!}
                            {!! Form::text('manufacturer', $asset->manufacturer , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('model', 'Model') !!}
                            {!! Form::text('model', $asset->model , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('serial_number', 'Serial number') !!}
                            {!! Form::text('serial_number', $asset->serial_number , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('year', 'Year') !!}
                            {!! Form::text('year', $asset->year , ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('location_id', 'Location') !!}
                            {!! Form::select('location_id', $locations, $asset->location_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('department_id', 'Department') !!}
                            {!! Form::select('department_id', $departments, $asset->department_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('parent_id', 'Parent') !!}
                            {!! Form::select('parent_id', $parents, $asset->parent_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('status', 'Status') !!}
                            {!! Form::text('status', $asset->status , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('remarks', 'Remarks') !!}
                            {!! Form::textarea('remarks', $asset->remarks, ['class' => 'form-control', 'rows' => 1]) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('is_active', 'Active:', ['class' => 'col-2']) !!}
                            {!! Form::checkbox('is_active', 1, $asset->is_active,['class' => 'col-1']) !!}
                        </div>

                    </div>

                    <h3 class="text-primary">Service information</h3>
                    <div class="row">
                        <div class="col-4">
                            {!! Form::label('manufacturer_id', 'Manufacturer') !!}
                            {!! Form::select('manufacturer_id', $vendors, $asset->manufacturer_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('vendor_id', 'Vendor') !!}
                            {!! Form::select('vendor_id', $vendors, $asset->vendor_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <h3 class="text-primary">Power specifications</h3>
                    <div class="row">
                        <div class="col-4">
                            {!! Form::label('power_line_voltage', 'Power line voltage') !!}
                            {!! Form::text('power_line_voltage', $asset->power_line_voltage , ['class' => 'form-control']) !!}
                            {!! Form::select('power_line_voltage_uom_id', $uoms_electric, $asset->power_line_voltage_uom_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('power_phase_voltage', 'Power phase voltage') !!}
                            {!! Form::text('power_phase_voltage', $asset->power_phase_voltage , ['class' => 'form-control']) !!}
                            {!! Form::select('power_phase_voltage_uom_id', $uoms_electric, $asset->power_phase_voltage_uom_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('power_phases', 'Power phases') !!}
                            {!! Form::text('power_phases', $asset->power_phases , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('power_amp', 'Power amps') !!}
                            {!! Form::text('power_amp', $asset->power_amp , ['class' => 'form-control']) !!}
                            {!! Form::select('power_amp_uom_id', $uoms_electric, $asset->power_amp_uom_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <h3 class="text-primary">Physical specifications</h3>
                    <div class="row">
                        <div class="col-4">
                            {!! Form::label('length', 'Length') !!}
                            {!! Form::text('length', $asset->length , ['class' => 'form-control']) !!}
                            {!! Form::select('length_uom_id', $uoms_length, $asset->length_uom_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('width', 'Width') !!}
                            {!! Form::text('width', $asset->width , ['class' => 'form-control']) !!}
                            {!! Form::select('width_uom_id', $uoms_length, $asset->width_uom_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('height', 'Height') !!}
                            {!! Form::text('height', $asset->height , ['class' => 'form-control']) !!}
                            {!! Form::select('height_uom_id', $uoms_length, $asset->height_uom_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('weight', 'Weight') !!}
                            {!! Form::text('weight', $asset->weight , ['class' => 'form-control']) !!}
                            {!! Form::select('weight_uom_id', $uoms_weight, $asset->weight_uom_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('capacity', 'Capacity') !!}
                            {!! Form::text('capacity', $asset->capacity , ['class' => 'form-control']) !!}
                            {!! Form::select('capacity_uom_id', $uoms_capacity, $asset->capacity_uom_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <h3 class="text-primary">Purchase info</h3>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('purchase_date', 'Purchase date') !!}
                            {!! Form::date('purchase_date', $asset->purchase_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('purchase_price', 'Purchase price') !!}
                            {!! Form::text('purchase_price', $asset->purchase_price , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('start_date', 'Start date') !!}
                            {!! Form::text('start_date', $asset->start_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('end_date', 'End date') !!}
                            {!! Form::text('end_date', $asset->end_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('life_expectancy', 'Life expectancy') !!}
                            {!! Form::text('life_expectancy', $asset->life_expectancy , ['class' => 'form-control']) !!}
                            {!! Form::select('life_expectancy_uom_id', $uoms_time, $asset->life_expectancy_uom_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('replacement_id', 'Replacement') !!}
                            {!! Form::select('replacement_id', $parents, $asset->replacement_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <h3 class="text-primary">Warranty info</h3>
                    <div class="row">
                        <div class="col-4">
                            {!! Form::label('warranty_start_date', 'Warranty start date') !!}
                            {!! Form::text('warranty_start_date', $asset->warranty_start_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('warranty_end_date', 'Warranty end date') !!}
                            {!! Form::text('warranty_end_date', $asset->warranty_end_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                    </div>

                    <h3 class="text-primary">Depreciation info</h3>
                    <div class="row">
                        <div class="col-4">
                            {!! Form::label('depreciation_start_date', 'Depreciation start date') !!}
                            {!! Form::text('depreciation_start_date', $asset->depreciation_start_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('depreciation_end_date', 'Depreciation end date') !!}
                            {!! Form::text('depreciation_end_date', $asset->depreciation_end_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('depreciation_type_id', 'Depreciation type') !!}
                            {!! Form::select('depreciation_type_id', $depreciation_types, $asset->depreciation_type_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('depreciation_rate', 'Depreciation rate') !!}
                            {!! Form::text('depreciation_rate', $asset->depreciation_rate , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('depreciation_value', 'Depreciation value') !!}
                            {!! Form::text('depreciation_value', $asset->depreciation_value , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('depreciation_time', 'Depreciation time') !!}
                            {!! Form::text('depreciation_time', $asset->depreciation_time , ['class' => 'form-control']) !!}
                            {!! Form::select('depreciation_time_uom_id', $uoms_time, $asset->depreciation_time_uom_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <h3 class="text-primary">Attachments</h3>
                    <div class="row">
                        <div class="col-4" id="attachments">
                            {!! Form::label('attachment', 'Attachment (max 10M): ')  !!}
                            {!! Form::file('attachment',['class' => 'form-control']); !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('attachment_description', 'Description: (max 200)')  !!}
                            {!! Form::text('attachment_description', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
