@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-export-list')
        <h1>
            Export list details: <strong><a href="{{url('admin/export_list/'.$export_list->id.'/edit')}}">{{ $export_list->label }}</a></strong>
        </h1>
        @else
        <h1>
            Export list details: <strong>{{$export_list->label}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <span class="font-weight-bold">Title: </span> {{$export_list->title}}<br />
        <span class="font-weight-bold">Label: </span> {{$export_list->label}}<br />
        <span class="font-weight-bold">Type: </span> {{$export_list->type}}<br />
        <span class="font-weight-bold">Start - End: </span> {{$export_list->start_date . ' - ' . $export_list->end_date}}<br />
        <span class="font-weight-bold">Last run: </span>{{$export_list->last_run_date}}<br />
        <span class="font-weight-bold">Next scheduled: </span>{{$export_list->next_scheduled_date}}<br />
        <span class="font-weight-bold">Fields: </span> {{$export_list->fields}}<br />
        <span class="font-weight-bold">Filters: </span> {{$export_list->filters}}<br />

    </div>
    <br />

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-export-list')
                    <a href="{{ action('ExportListController@edit', $export_list->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-export-list')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['export_list.destroy', $export_list->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
