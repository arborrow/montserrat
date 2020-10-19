@extends('template')
@section('content')

<div class="row bg-cover" style="border:1px;">
    <div class="col-12">
        @can('update-asset-task')
        <h1>
            Asset task details: <strong><a href="{{url('asset_task/'.$asset_task->id.'/edit')}}">{{ $asset_task->asset_name . ': ' . $asset_task->title }}</a></strong>
        </h1>
        @else
        <h1>
            Asset task details: <strong>{{$asset_task->asset_name . ': ' . $asset_task->title}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-3"><strong>Asset:</strong> <a href="{{ URL('asset_task/'.$asset_task->id) }}">{{$asset_task->asset_name}}</a></div>
            <div class="col-3"><strong>Title:</strong> {{$asset_task->title}}</div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Start date:</strong> {{$asset_task->start_date}}</div>
            <div class="col-3"><strong>Scheduled until date:</strong> {{$asset_task->scheduled_until_date}}</div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Frequency interval:</strong> {{$asset_task->frequency_interval}}</div>
            <div class="col-3"><strong>Frequency:</strong> {{$asset_task->frequency}}</div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Frequency month:</strong> {{$asset_task->frequency_month}}</div>
            <div class="col-3"><strong>Frequency day:</strong> {{$asset_task->frequency_day}}</div>
            <div class="col-3"><strong>Frequency time:</strong> {{$asset_task->frequency_time}}</div>
        </div>
        <div class="row">
            <div class="col-6"><strong>Description:</strong> {{$asset_task->description}}</div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Priority:</strong> {{$asset_task->priority_id}}</div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Labor (minutes):</strong> {{$asset_task->needed_labor_minutes}}</div>
            <div class="col-3"><strong>Estimated labor cost:</strong> {{$asset_task->estimated_labor_cost}}</div>
        </div>
        <div class="row">
            <div class="col-6"><strong>Needed material:</strong> {{$asset_task->needed_material}}</div>
            <div class="col-3"><strong>Estimated material cost:</strong> {{$asset_task->estimated_material_cost}}</div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Vendor:</strong> {{$asset_task->vendor_id}}</div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Category:</strong> {{$asset_task->category}}</div>
            <div class="col-3"><strong>Tag:</strong> {{$asset_task->tag}}</div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-6 text-right">
                @can('update-asset-task')
                <a href="{{ action('AssetTaskController@edit', $asset_task->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-6 text-left">
                @can('delete-asset-task')
                {!! Form::open(['method' => 'DELETE', 'route' => ['asset_task.destroy', $asset_task->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
