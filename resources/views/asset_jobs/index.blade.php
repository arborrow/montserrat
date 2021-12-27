@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Asset jobs
            @can('create-asset-job')
            <span class="options">
                <a href={{ action('AssetJobController@create') }}>
                    <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                </a>
            </span>
            @endCan
        </h2>
    </div>
    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($asset_jobs->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>It is a brand new world, there are no asset jobs!</p>
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
                @foreach($asset_jobs as $asset_job)
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
</div>
@stop
