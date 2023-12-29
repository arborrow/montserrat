@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create asset job</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'asset_job')->acceptsFiles()->open() }}
        <div class="form-group">

            <h3 class="text-primary">Job info</h3>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Asset task', 'asset_task_id') }}
                    {{ html()->select('asset_task_id', $asset_tasks)->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Assigned to', 'assigned_to_id') }}
                    {{ html()->select('assigned_to_id', $staff)->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Status', 'status') }}
                    {{ html()->select('status', $status, config('polanco.asset_job_status.scheduled'))->class('form-control') }}
                </div>
            </div>

            <h3 class="text-primary">Job dates</h3>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Scheduled', 'scheduled_date') }}
                    {{ html()->date('scheduled_date')->class('form-control flatpickr-date-time')->attribute('autocomplete', 'off') }}
                </div>

                <div class="col-lg-3">
                    {{ html()->label('Started', 'start_date') }}
                    {{ html()->date('start_date')->class('form-control flatpickr-date-time')->attribute('autocomplete', 'off') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Ended', 'end_date') }}
                    {{ html()->date('end_date')->class('form-control flatpickr-date-time')->attribute('autocomplete', 'off') }}
                </div>
            </div>

            <h3 class="text-primary">Labor & materials</h3>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Actual labor (minutes)', 'actual_labor') }}
                    {{ html()->text('actual_labor')->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Actual labor cost', 'actual_labor_cost') }}
                    {{ html()->number('actual_labor_cost', 0)->class('form-control')->attribute('step', '0.01') }}
                </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                  {{ html()->label('Additional materials', 'additional_materials') }}
                  {{ html()->textarea('additional_materials')->class('form-control')->rows(2) }}
              </div>
                <div class="col-lg-3">
                    {{ html()->label('Actual material cost', 'actual_material_cost') }}
                    {{ html()->number('actual_material_cost', 0)->class('form-control')->attribute('step', '0.01') }}
                </div>
            </div>

            <h3 class="text-primary">Notes</h3>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Note', 'note') }}
                    {{ html()->textarea('note')->class('form-control')->rows(2) }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Tag', 'tag') }}
                    {{ html()->text('tag')->class('form-control') }}
                </div>
            </div>

        </div>
        <div class="row text-center">
            <div class="col-lg-12">
                {{ html()->submit('Add asset job')->class('btn btn-outline-dark') }}
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
