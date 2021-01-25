@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>Create asset task</h1>
    </div>
    <div class="col-12">
        {!! Form::open(['url'=>'asset_task', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('asset_id', 'Asset') !!}
                    {!! Form::select('asset_id', $assets, NULL, ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('title', 'Task') !!}
                    {!! Form::text('title', NULL , ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('start_date', 'Start date') !!}
                    {!! Form::date('start_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('scheduled_until_date', 'Scheduled until date') !!}
                    {!! Form::date('scheduled_until_date', null, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('frequency_interval', 'Every') !!}
                    {!! Form::text('frequency_interval', 1, ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('frequency', 'Frequency') !!}
                    {!! Form::select('frequency', $frequencies, NULL, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('frequency_month', 'Month') !!}
                    {!! Form::text('frequency_month', NULL , ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('frequency_day', 'Day') !!}
                    {!! Form::text('frequency_day', NULL , ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('frequency_time', 'Time') !!}
                    {!! Form::text('frequency_time', null, ['class'=>'form-control flatpickr-time', 'autocomplete'=> 'off']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    {!! Form::label('description', 'Detailed description') !!}
                    {!! Form::textarea('description', NULL, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('priority_id', 'Priority') !!}
                    {!! Form::select('priority_id', $priorities, 3, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('needed_labor_minutes', 'Estimated labor (minutes)') !!}
                    {!! Form::text('needed_labor_minutes', NULL , ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('estimated_labor_cost', 'Estimated labor cost') !!}
                    {!! Form::text('estimated_labor_cost', NULL , ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    {!! Form::label('needed_material', 'Needed materials') !!}
                    {!! Form::textarea('needed_material', NULL, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('estimated_material_cost', 'Estimated material cost') !!}
                    {!! Form::text('estimated_material_cost', NULL , ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('vendor_id', 'Vendor') !!}
                    {!! Form::select('vendor_id', $vendors, NULL, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('category', 'Category') !!}
                    {!! Form::text('category', NULL , ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('tag', 'Tag') !!}
                    {!! Form::text('tag', NULL , ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-12">
                {!! Form::submit('Add asset task', ['class'=>'btn btn-outline-dark']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
