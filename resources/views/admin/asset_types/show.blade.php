@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-asset-type')
        <h1>
            Asset type details: <strong><a href="{{url('admin/asset_type/'.$asset_type->id.'/edit')}}">{{ $asset_type->label }}</a></strong>
        </h1>
        @else
        <h1>
            Asset type details: <strong>{{$asset_type->label}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <span class="font-weight-bold">Label: </span> {{$asset_type->label}}<br />
        <span class="font-weight-bold">Name: </span> {{$asset_type->name}}<br />
        <span class="font-weight-bold">Description: </span> {{$asset_type->description}}<br />
        <span class="font-weight-bold">Parent: </span> {{$asset_type->parent_label}}<br />
        <span class="font-weight-bold">Active: </span>{{$asset_type->is_active ? 'Yes':'No'}}

    </div>
    <br />

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 mt-4 mb-4">
                @can('update-asset-type')
                    <a href="{{ action('AssetTypeController@edit', $asset_type->id) }}" class="btn btn-info mr-4">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
                @can('delete-asset-type')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['asset_type.destroy', $asset_type->id],'onsubmit'=>'return ConfirmDelete()','class' => 'd-inline']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
