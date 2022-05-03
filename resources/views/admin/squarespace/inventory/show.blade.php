@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-ss-custom-form')
            <h1>
                SquareSpace Inventory: <strong><a href="{{url('admin/squarespace/inventory/'.$inventory->id.'/edit')}}">{{ $inventory->name }}</a></strong>
            </h1>
        @else
            <h1>
                SquareSpace Inventory: <strong>{{$inventory->name}}</strong>
            </h1>
        @endCan
    </div>
    <div class="row">
            Custom Form: {{ optional($inventory->custom_form)->name }}
    </div>
    <div class="col-lg-12 mb-4">
        @can('update-ss-custom-form')
            <a href="{{ action([\App\Http\Controllers\SsCustomFormController::class, 'edit'], $inventory->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>

        @endcan
        @can('delete-ss-custom-form')
                {!! Form::open(['method' => 'DELETE', 'route' => ['inventory.destroy', $inventory->id], 'onsubmit'=>'return ConfirmDelete()', 'class' => 'd-inline']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}

        @endcan

    </div>
</div>
@stop
