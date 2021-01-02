@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit asset job #{{ $asset_job->id }}</h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['asset_job.update', $asset_job->id],'enctype'=>'multipart/form-data']) !!}
                {!! Form::hidden('id', $asset_job->id) !!}
                <div class="form-group">

                  <h3 class="text-primary">Job info</h3>
                  <div class="row">
                      <div class="col-3">
                          <strong>Asset:</strong> {{ $asset_job->asset_task->asset->name }}
                      </div>
                      <div class="col-3">
                          {!! Form::label('asset_task_id', 'Asset task') !!}
                          {!! Form::select('asset_task_id', $asset_tasks, $asset_job->asset_task_id, ['class' => 'form-control']) !!}
                      </div>
                      <div class="col-3">
                          {!! Form::label('assigned_to_id', 'Assigned to') !!}
                          {!! Form::select('assigned_to_id', $staff, $asset_job->assigned_to_id, ['class' => 'form-control']) !!}
                      </div>
                      <div class="col-3">
                          {!! Form::label('status', 'Status') !!}
                          {!! Form::select('status', $status, $asset_job->status, ['class' => 'form-control']) !!}
                      </div>
                  </div>

                  <h3 class="text-primary">Job dates</h3>
                  <div class="row">
                      <div class="col-3">
                          {!! Form::label('scheduled_date', 'Scheduled') !!}
                          {!! Form::date('scheduled_date', $asset_job->scheduled_date, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                      </div>

                      <div class="col-3">
                          {!! Form::label('start_date', 'Started') !!}
                          {!! Form::date('start_date', $asset_job->start_date, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                      </div>
                      <div class="col-3">
                          {!! Form::label('end_date', 'Ended') !!}
                          {!! Form::date('end_date', $asset_job->end_date, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                      </div>
                  </div>

                  <h3 class="text-primary">Labor & materials</h3>
                  <div class="row">
                      <div class="col-3">
                          {!! Form::label('actual_labor', 'Actual labor (minutes)') !!}
                          {!! Form::text('actual_labor', $asset_job->actual_labor , ['class' => 'form-control']) !!}
                      </div>
                      <div class="col-3">
                          {!! Form::label('actual_labor_cost', 'Actual labor cost') !!}
                          {!! Form::number('actual_labor_cost', $asset_job->actual_labor_cost, ['class' => 'form-control','step'=>'0.01']) !!}
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-3">
                        {!! Form::label('additional_materials', 'Additional materials') !!}
                        {!! Form::textarea('additional_materials', $asset_job->additional_materials, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                      <div class="col-3">
                          {!! Form::label('actual_material_cost', 'Actual material cost') !!}
                          {!! Form::number('actual_material_cost', $asset_job->actual_material_cost, ['class' => 'form-control','step'=>'0.01']) !!}
                      </div>
                  </div>

                  <h3 class="text-primary">Notes</h3>
                  <div class="row">
                      <div class="col-3">
                          {!! Form::label('note', 'Notes') !!}
                          {!! Form::textarea('note', $asset_job->note, ['class' => 'form-control', 'rows' => 2]) !!}
                      </div>
                      <div class="col-3">
                          {!! Form::label('tag', 'Tag') !!}
                          {!! Form::text('tag', $asset_job->tag , ['class' => 'form-control']) !!}
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
