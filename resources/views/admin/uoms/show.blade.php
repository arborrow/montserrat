@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-uom')
        <h1>
            Unit of measure details: <strong><a href="{{url('admin/uom/'.$uom->id.'/edit')}}">{{ $uom->unit_name }}</a></strong>
        </h1>
        @else
        <h1>
            Unit of measure details: <strong>{{$uom->unit_name}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <span class="font-weight-bold">Type: </span> {{$uom->type}}<br />
        <span class="font-weight-bold">Unit name: </span> {{$uom->unit_name}}<br />
        <span class="font-weight-bold">Unit symbol: </span> {{$uom->unit_symbol}}<br />
        <span class="font-weight-bold">Description: </span> {{$uom->description}}<br />
        <span class="font-weight-bold">Active: </span>{{$uom->is_active ? 'Yes':'No'}}

    </div>
    <br />

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-uom')
                    <a href="{{ action([\App\Http\Controllers\UomController::class, 'edit'], $uom->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-uom')
                    {{ html()->form('DELETE', route('uom.destroy', [$uom->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                    {{ html()->form()->close() }}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
