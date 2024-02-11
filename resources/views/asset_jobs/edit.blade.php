@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit asset job #{{ $asset_job->id }}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                {{ html()->form('PUT', route('asset_job.update', [$asset_job->id]))->acceptsFiles()->open() }}
                {{ html()->hidden('id', $asset_job->id) }}
                <div class="form-group">

                  <h3 class="text-primary">Job info</h3>
                  <div class="row">
                      <div class="col-lg-3">
                          <strong>Asset:</strong> {{ $asset_job->asset_task->asset->name }}
                      </div>
                      <div class="col-lg-3">
                          {{ html()->label('Asset task', 'asset_task_id') }}
                          {{ html()->select('asset_task_id', $asset_tasks, $asset_job->asset_task_id)->class('form-control') }}
                      </div>
                      <div class="col-lg-3">
                          {{ html()->label('Assigned to', 'assigned_to_id') }}
                          {{ html()->select('assigned_to_id', $staff, $asset_job->assigned_to_id)->class('form-control') }}
                      </div>
                      <div class="col-lg-3">
                          {{ html()->label('Status', 'status') }}
                          {{ html()->select('status', $status, $asset_job->status)->class('form-control') }}
                      </div>
                  </div>

                  <h3 class="text-primary">Job dates</h3>
                  <div class="row">
                      <div class="col-lg-3">
                          {{ html()->label('Scheduled', 'scheduled_date') }}
                          {{ html()->date('scheduled_date', $asset_job->scheduled_date)->class('form-control flatpickr-date-time')->attribute('autocomplete', 'off') }}
                      </div>

                      <div class="col-lg-3">
                          {{ html()->label('Started', 'start_date') }}
                          {{ html()->date('start_date', $asset_job->start_date)->class('form-control flatpickr-date-time')->attribute('autocomplete', 'off') }}
                      </div>
                      <div class="col-lg-3">
                          {{ html()->label('Ended', 'end_date') }}
                          {{ html()->date('end_date', $asset_job->end_date)->class('form-control flatpickr-date-time')->attribute('autocomplete', 'off') }}
                      </div>
                  </div>

                  <h3 class="text-primary">Labor & materials</h3>
                  <div class="row">
                      <div class="col-lg-3">
                          {{ html()->label('Actual labor (minutes)', 'actual_labor') }}
                          {{ html()->text('actual_labor', $asset_job->actual_labor)->class('form-control') }}
                      </div>
                      <div class="col-lg-3">
                          {{ html()->label('Actual labor cost', 'actual_labor_cost') }}
                          {{ html()->number('actual_labor_cost', $asset_job->actual_labor_cost)->class('form-control')->attribute('step', '0.01') }}
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Additional materials', 'additional_materials') }}
                        {{ html()->textarea('additional_materials', $asset_job->additional_materials)->class('form-control')->rows(2) }}
                    </div>
                      <div class="col-lg-3">
                          {{ html()->label('Actual material cost', 'actual_material_cost') }}
                          {{ html()->number('actual_material_cost', $asset_job->actual_material_cost)->class('form-control')->attribute('step', '0.01') }}
                      </div>
                  </div>

                  <h3 class="text-primary">Notes</h3>
                  <div class="row">
                      <div class="col-lg-3">
                          {{ html()->label('Notes', 'note') }}
                          {{ html()->textarea('note', $asset_job->note)->class('form-control')->rows(2) }}
                      </div>
                      <div class="col-lg-3">
                          {{ html()->label('Tag', 'tag') }}
                          {{ html()->text('tag', $asset_job->tag)->class('form-control') }}
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
