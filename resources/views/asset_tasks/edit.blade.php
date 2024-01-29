@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {{ $asset_task->asset_name . ': ' . $asset_task->title }}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Asset task</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('asset_task.update', [$asset_task->id]))->acceptsFiles()->open() }}
                {{ html()->hidden('id', $asset_task->id) }}
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Asset', 'asset_id') }}
                            {{ html()->select('asset_id', $assets, $asset_task->asset_id)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Title', 'title') }}
                            {{ html()->text('title', $asset_task->title)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Start date', 'start_date') }}
                            {{ html()->date('start_date', $asset_task->start_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Scheduled until date', 'scheduled_until_date') }}
                            {{ html()->date('scheduled_until_date', $asset_task->scheduled_until_date)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Every', 'frequency_interval') }}
                            {{ html()->text('frequency_interval', $asset_task->frequency_interval)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Frequency', 'frequency') }}
                            {{ html()->select('frequency', $frequencies, $asset_task->frequency)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Month', 'frequency_month') }}
                            {{ html()->text('frequency_month', $asset_task->frequency_month)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Day', 'frequency_day') }}
                            {{ html()->text('frequency_day', $asset_task->frequency_day)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Time', 'frequency_time') }}
                            {{ html()->text('frequency_time', $asset_task->frequency_time)->class('form-control flatpickr-time')->attribute('autocomplete', 'off') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            {{ html()->label('Description', 'description') }}
                            {{ html()->textarea('description', $asset_task->description)->class('form-control')->rows(3) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Priority', 'priority_id') }}
                            {{ html()->select('priority_id', $priorities, $asset_task->priority_id)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Estimated labor (minutes)', 'needed_labor_minutes') }}
                            {{ html()->text('needed_labor_minutes', $asset_task->needed_labor_minutes)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Estimated labor cost', 'estimated_labor_cost') }}
                            {{ html()->number('estimated_labor_cost', $asset_task->estimated_labor_cost)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            {{ html()->label('Needed materials', 'needed_material') }}
                            {{ html()->textarea('needed_material', $asset_task->needed_material)->class('form-control')->rows(3) }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Estimated material cost', 'estimated_material_cost') }}
                            {{ html()->number('estimated_material_cost', $asset_task->estimated_material_cost)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Vendor', 'vendor_id') }}
                            {{ html()->select('vendor_id', $vendors, $asset_task->vendor_id)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Category', 'category') }}
                            {{ html()->text('category', $asset_task->category)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Tag', 'tag') }}
                            {{ html()->text('tag', $asset_task->tag)->class('form-control') }}
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
    </div>
</div>
@stop
