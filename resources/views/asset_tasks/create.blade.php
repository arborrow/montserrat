@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create asset task</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('asset_task'))->acceptsFiles()->open() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Asset', 'asset_id') }}
                    {{ html()->select('asset_id', $assets)->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Task', 'title') }}
                    {{ html()->text('title')->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Start date', 'start_date') }}
                    {{ html()->date('start_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Scheduled until date', 'scheduled_until_date') }}
                    {{ html()->date('scheduled_until_date')->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Every', 'frequency_interval') }}
                    {{ html()->text('frequency_interval', 1)->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Frequency', 'frequency') }}
                    {{ html()->select('frequency', $frequencies)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Month', 'frequency_month') }}
                    {{ html()->text('frequency_month')->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Day', 'frequency_day') }}
                    {{ html()->text('frequency_day')->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Time', 'frequency_time') }}
                    {{ html()->text('frequency_time')->class('form-control flatpickr-time')->attribute('autocomplete', 'off') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    {{ html()->label('Detailed description', 'description') }}
                    {{ html()->textarea('description')->class('form-control')->rows(3) }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Priority', 'priority_id') }}
                    {{ html()->select('priority_id', $priorities, 3)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Estimated labor (minutes)', 'needed_labor_minutes') }}
                    {{ html()->text('needed_labor_minutes')->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Estimated labor cost', 'estimated_labor_cost') }}
                    {{ html()->text('estimated_labor_cost')->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    {{ html()->label('Needed materials', 'needed_material') }}
                    {{ html()->textarea('needed_material')->class('form-control')->rows(3) }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Estimated material cost', 'estimated_material_cost') }}
                    {{ html()->text('estimated_material_cost')->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Vendor', 'vendor_id') }}
                    {{ html()->select('vendor_id', $vendors)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    {{ html()->label('Category', 'category') }}
                    {{ html()->text('category')->class('form-control') }}
                </div>
                <div class="col-lg-3">
                    {{ html()->label('Tag', 'tag') }}
                    {{ html()->text('tag')->class('form-control') }}
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12">
                {{ html()->submit('Add asset task')->class('btn btn-outline-dark') }}
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
