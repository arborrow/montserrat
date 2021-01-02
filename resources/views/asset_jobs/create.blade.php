@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>Create asset job</h1>
    </div>
    <div class="col-12">
        {!! Form::open(['url'=>'asset_job', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group">

            <h3 class="text-primary">Job info</h3>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('asset_task_id', 'Asset task') !!}
                    {!! Form::select('asset_task_id', $asset_tasks, NULL, ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('assigned_to_id', 'Assigned to') !!}
                    {!! Form::select('assigned_to_id', $staff, NULL, ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', $status, config('polanco.asset_job_status.scheduled'), ['class' => 'form-control']) !!}
                </div>
            </div>

            <h3 class="text-primary">Job dates</h3>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('scheduled_date', 'Scheduled') !!}
                    {!! Form::date('scheduled_date', null, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>

                <div class="col-3">
                    {!! Form::label('start_date', 'Started') !!}
                    {!! Form::date('start_date', null, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('end_date', 'Ended') !!}
                    {!! Form::date('end_date', null, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>
            </div>

            <h3 class="text-primary">Labor & materials</h3>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('actual_labor', 'Actual labor (minutes)') !!}
                    {!! Form::text('actual_labor', NULL , ['class' => 'form-control']) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('actual_labor_cost', 'Actual labor cost') !!}
                    {!! Form::number('actual_labor_cost', 0, ['class' => 'form-control','step'=>'0.01']) !!}
                </div>
            </div>
            <div class="row">
              <div class="col-3">
                  {!! Form::label('additional_materials', 'Additional materials') !!}
                  {!! Form::textarea('additional_materials', NULL, ['class' => 'form-control', 'rows' => 2]) !!}
              </div>
                <div class="col-3">
                    {!! Form::label('actual_material_cost', 'Actual material cost') !!}
                    {!! Form::number('actual_material_cost', 0, ['class' => 'form-control','step'=>'0.01']) !!}
                </div>
            </div>

            <h3 class="text-primary">Notes</h3>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('note', 'Note') !!}
                    {!! Form::textarea('note', NULL, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
                <div class="col-3">
                    {!! Form::label('tag', 'Tag') !!}
                    {!! Form::text('tag', NULL , ['class' => 'form-control']) !!}
                </div>
            </div>

        </div>
        <div class="row text-center">
            <div class="col-12">
                {!! Form::submit('Add asset job', ['class'=>'btn btn-outline-dark']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
