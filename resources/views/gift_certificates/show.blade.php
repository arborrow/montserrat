@extends('template')
@section('content')

<div class="row bg-cover" style="border:1px;">
    <div class="col-lg-12">

        @can('update-asset-job')
        <h1>
            Asset job <strong><a href="{{url('asset_job/'.$asset_job->id.'/edit')}}">#{{ $asset_job->id }}</a></strong>
        </h1>
        @else
        <h1>
            Asset job <strong>#{{$asset_job->id}}</strong>
        </h1>
        @endCan
    </div>

    <div class="col-lg-12">
        <h3 class="text-primary">Job info</h3>
        <div class="row">
            <div class="col-lg-3"><strong>Asset:</strong>
                <a href="{{ URL('asset/'.$asset_job->asset_task->asset->id) }}">
                    {{ $asset_job->asset_task->asset->name }}
                </a>
            </div>

            <div class="col-lg-3"><strong>Asset task:</strong>
                <a href="{{ URL('asset_task/'.$asset_job->asset_task->id) }}">
                    {{ $asset_job->asset_task->title }}
                </a>
            </div>

            <div class="col-lg-3"><strong>Assigned to:</strong>
                  <a href="{{$asset_job->assigned_to->contact_url}}">
                      {{ $asset_job->assigned_to->sort_name }}
                  </a>
            </div>
        </div>
        <h3 class="text-primary">Job dates</h3>
        <div class="row">

            <div class="col-lg-3"><strong>Scheduled:</strong> {{$asset_job->scheduled_date}}</div>
            <div class="col-lg-2"><strong>Start:</strong> {{$asset_job->start_date}}</div>
            <div class="col-lg-2"><strong>End:</strong> {{$asset_job->end_date}}</div>
        </div>

        <h3 class="text-primary">Labor & materials</h3>
        <div class="row">
            <div class="col-lg-3"><strong>Actual labor (minutes):</strong> {{$asset_job->actual_labor}}</div>
            <div class="col-lg-3"><strong>Actual labor cost:</strong> {{$asset_job->actual_labor_cost}}</div>
            <div class="col-lg-3"><strong>Additional materials:</strong> {{$asset_job->additional_materials}}</div>
            <div class="col-lg-3"><strong>Actual material cost:</strong> {{$asset_job->actual_material_cost}}</div>
        </div>

        <h3 class="text-primary">Notes</h3>
        <div class="row">
            <div class="col-lg-3"><strong>Notes:</strong> {{$asset_job->note}}</div>
            <div class="col-lg-3"><strong>Tag:</strong> {{$asset_job->tag}}</div>
        </div>

    </div>

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-asset')
                <a href="{{ action([\App\Http\Controllers\AssetJobController::class, 'edit'], $asset_job->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-asset')
                {!! Form::open(['method' => 'DELETE', 'route' => ['asset_job.destroy', $asset_job->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
