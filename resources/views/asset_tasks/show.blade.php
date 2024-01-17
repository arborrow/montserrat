@extends('template')
@section('content')

<div class="row bg-cover" style="border:1px;">
    <div class="col-lg-12">
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
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3"><strong>Asset:</strong> <a href="{{ URL('asset/'.$asset_task->asset_id) }}">{{$asset_task->asset_name}}</a></div>
            <div class="col-lg-3"><strong>Task:</strong> {{$asset_task->title}}</div>
        </div>
        <div class="row">
            <div class="col-lg-3"><strong>Start date:</strong> {{$asset_task->start_date}}</div>
            <div class="col-lg-3"><strong>Scheduled until date:</strong> {{$asset_task->scheduled_until_date}}</div>
        </div>
        <div class="row">
            <div class="col-lg-3"><strong>Frequency interval:</strong> {{$asset_task->frequency_interval}}</div>
            <div class="col-lg-3"><strong>Frequency:</strong> {{$asset_task->frequency}}</div>
        </div>
        <div class="row">
            <div class="col-lg-3"><strong>Frequency month:</strong> {{$asset_task->frequency_month}}</div>
            <div class="col-lg-3"><strong>Frequency day:</strong> {{$asset_task->frequency_day}}</div>
            <div class="col-lg-3"><strong>Frequency time:</strong> {{$asset_task->frequency_time}}</div>
        </div>
        <div class="row">
            <div class="col-lg-6"><strong>Detailed description:</strong> {{$asset_task->description}}</div>
        </div>
        <div class="row">
            <div class="col-lg-3"><strong>Priority:</strong> {{$asset_task->priority_id}}</div>
        </div>
        <div class="row">
            <div class="col-lg-3"><strong>Labor (minutes):</strong> {{$asset_task->needed_labor_minutes}}</div>
            <div class="col-lg-3"><strong>Estimated labor cost:</strong> {{$asset_task->estimated_labor_cost}}</div>
        </div>
        <div class="row">
            <div class="col-lg-6"><strong>Needed material:</strong> {{$asset_task->needed_material}}</div>
            <div class="col-lg-3"><strong>Estimated material cost:</strong> {{$asset_task->estimated_material_cost}}</div>
        </div>
        <div class="row">
            <div class="col-lg-3"><strong>Vendor:</strong> {{$asset_task->vendor_id}}</div>
        </div>
        <div class="row">
            <div class="col-lg-3"><strong>Category:</strong> {{$asset_task->category}}</div>
            <div class="col-lg-3"><strong>Tag:</strong> {{$asset_task->tag}}</div>
        </div>
        <div class="row"></div>
    </div>

    <div class="col-lg-12 my-3 table-responsive-md">
      <h3 class="text-primary">Scheduled jobs</h3>
      @can('create-asset-job')
        <a href={{ url('asset_job/create/'.$asset_task->id) }} class="btn btn-outline-dark">Add job</a>
        <a href={{ url('asset_task/'.$asset_task->id.'/schedule_jobs') }} class="btn btn-outline-dark">Schedule jobs</a>
      @endCan

        @if ($jobs_scheduled->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>There are no scheduled jobs for this task</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Scheduled</th>
                    <th scope="col">Asset</th>
                    <th scope="col">Task</th>
                    <th scope="col">Assigned</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs_scheduled as $asset_job)
                <tr>
                    <td><a href="{{URL('asset_job/'.$asset_job->id)}}">{{ $asset_job->scheduled_date }}</a></td>
                    <td><a href="{{URL('asset/'.$asset_job->asset_task->asset->id)}}">{{ $asset_job->asset_task->asset->name }}</a></td>
                    <td><a href="{{URL('asset_task/'.$asset_job->asset_task->id)}}">{{ $asset_job->asset_task->title }}</a></td>
                    <td><a href="{{$asset_job->assigned_contact_url}}">{{ $asset_job->assigned_sort_name }}</a></td>
                    <td>{{ $asset_job->status }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>

    <div class="col-lg-12 my-3 table-responsive-md">
      <h3 class="text-primary">Past jobs</h3>
        @if ($jobs_past->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>There are no past jobs for this task</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Scheduled</th>
                    <th scope="col">Asset</th>
                    <th scope="col">Task</th>
                    <th scope="col">Assigned</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs_past as $asset_job)
                <tr>
                    <td><a href="{{URL('asset_job/'.$asset_job->id)}}">{{ $asset_job->scheduled_date }}</a></td>
                    <td><a href="{{URL('asset/'.$asset_job->asset_task->asset->id)}}">{{ $asset_job->asset_task->asset->name }}</a></td>
                    <td><a href="{{URL('asset_task/'.$asset_job->asset_task->id)}}">{{ $asset_job->asset_task->title }}</a></td>
                    <td><a href="{{$asset_job->assigned_contact_url}}">{{ $asset_job->assigned_sort_name }}</a></td>
                    <td>{{ $asset_job->status }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-asset-task')
                  <a href="{{ action([\App\Http\Controllers\AssetTaskController::class, 'edit'], $asset_task->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-asset-task')
                {{ html()->form('DELETE', route('asset_task.destroy', [$asset_task->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                {{ html()->form()->close() }}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
