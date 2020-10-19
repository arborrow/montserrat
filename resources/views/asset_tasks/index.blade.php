@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>
            Asset tasks
            @can('create-asset-task')
            <span class="options">
                <a href={{ action('AssetTaskController@create') }}>
                    <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                </a>
            </span>
            @endCan

        </h2>
    </div>
    <div class="col-12 my-3 table-responsive-md">
        @if ($asset_tasks->isEmpty())
        <div class="col-12 text-center py-5">
            <p>It is a brand new world, there are no asset tasks!</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Asset</th>
                    <th scope="col">Start/Until</th>
                    <th scope="col">Frequency</th>
                    <th scope="col">Priority</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asset_tasks as $asset_task)
                <tr>
                    <td><a href="{{ URL('asset_task/'.$asset_task->id) }}">{{ $asset_task->title }}</a></td>
                    <td><a href="{{URL('asset/'.$asset_task->asset_id)}}">{{ $asset_task->asset_name }}</a></td>
                    <td>{{ $asset_task->start_date . ' - ' . $asset_task->scheduled_until_date }}</td>
                    <td>{{ $asset_task->frequency }}</td>
                    <td>{{ $asset_task->priority_id }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
