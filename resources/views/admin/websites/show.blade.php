@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-website')
        <h1>
            Website details: <strong><a href="{{url('admin/website/'.$website->id.'/edit')}}">{{ $website->url }}</a></strong>
        </h1>
        @else
        <h1>
            Website details: <strong>{{$website->url}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <span class="font-weight-bold">Website type:</span> {{$website->website_type}}<br />
        <span class="font-weight-bold">URL: </span> {{$website->url}}<br />
        <span class="font-weight-bold">Description: </span> {{$website->description}}<br />
        <span class="font-weight-bold">Contact ID: </span>{{$website->contact_id}}<br />
        <span class="font-weight-bold">Asset ID: </span>{{$website->asset_id}}
    </div>
    <br />

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-website')
                    <a href="{{ action('WebsiteController@edit', $website->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-website')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['website.destroy', $website->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
