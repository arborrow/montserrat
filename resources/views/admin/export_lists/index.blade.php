@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>
            Export list
            @can('create-export_list')
                <span class="options">
                    <a href={{ action('ExportListController@create') }}>
                        <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
    </div>
    <div class="col-12 my-3 table-responsive-md">
        @if ($export_lists->isEmpty())
            <div class="col-12 text-center py-5">
                <p>It is a brand new world, there are no export lists!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Label</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Fields/Filters</th>
                        <th scope="col">Start/End Dates</th>
                        <th scope="col">Run/Scheduled Dates</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($export_lists as $export_list)
                    <tr>
                        <td><a href="{{URL('admin/export_list/'.$export_list->id)}}">{{ $export_list->label }}</a></td>
                        <td>{{ $export_list->title }}</td>
                        <td>{{ $export_list->type }}</td>
                        <td>
                            {{ $export_list->fields }} <br>
                            {{ $export_list->filters }}
                        </td>
                        <td>{{ $export_list->start_date . ' - ' . $export_list->end_date }}</td>
                        <td>{{ $export_list->last_run_date . ' - ' . $export_list->next_scheduled_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
