@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit: {{ $asset_task->asset_name . ': ' . $asset_task->title }}</h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <h2>Asset task</h2>
            </div>
            <div class="col-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['asset_task.update', $asset_task->id],'enctype'=>'multipart/form-data']) !!}
                {!! Form::hidden('id', $asset_task->id) !!}
                <div class="form-group">
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('asset_id', 'Asset') !!}
                            {!! Form::select('asset_id', $assets, $asset_task->asset_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('title', 'Title') !!}
                            {!! Form::text('title', $asset_task->title , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('start_date', 'Start date') !!}
                            {!! Form::date('start_date', $asset_task->start_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('scheduled_until_date', 'Scheduled until date') !!}
                            {!! Form::date('scheduled_until_date', $asset_task->scheduled_until_date, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('frequency_interval', 'Every') !!}
                            {!! Form::text('frequency_interval', $asset_task->frequency_interval , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('frequency', 'Frequency') !!}
                            {!! Form::select('frequency', $frequencies, $asset_task->frequency, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('frequency_month', 'Month') !!}
                            {!! Form::text('frequency_month', $asset_task->frequency_month , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('frequency_day', 'Day') !!}
                            {!! Form::text('frequency_day', $asset_task->frequency_day , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('frequency_time', 'Time') !!}
                            {!! Form::time('frequency_time', $asset_task->frequency_time, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', $asset_task->description, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('priority_id', 'Priority') !!}
                            {!! Form::select('priority_id', $priorities, $asset_task->priority_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('needed_labor_minutes', 'Estimated labor (minutes)') !!}
                            {!! Form::text('needed_labor_minutes', $asset_task->needed_labor_minutes , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('estimated_labor_cost', 'Estimated labor cost') !!}
                            {!! Form::number('estimated_labor_cost', $asset_task->estimated_labor_cost , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            {!! Form::label('needed_material', 'Needed materials') !!}
                            {!! Form::textarea('needed_material', $asset_task->needed_material, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('estimated_material_cost', 'Estimated material cost') !!}
                            {!! Form::number('estimated_material_cost', $asset_task->estimated_material_cost , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('vendor_id', 'Vendor') !!}
                            {!! Form::select('vendor_id', $vendors, $asset_task->vendor_id, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            {!! Form::label('category', 'Category') !!}
                            {!! Form::text('category', $asset_task->category , ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('tag', 'Tag') !!}
                            {!! Form::text('tag', $asset_task->tag , ['class' => 'form-control']) !!}
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
    </div>
</div>
@stop
