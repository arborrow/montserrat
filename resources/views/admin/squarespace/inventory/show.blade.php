@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-ss-custom-form')
            <h1>
                Squarespace Inventory details: <strong><a
                        href="{{ url('admin/squarespace/inventory/' . $inventory->id . '/edit') }}">{{ $inventory->name }}</a></strong>
            </h1>
        @else
            <h1>
                Squarespace Inventory details: <strong>{{ $inventory->name }}</strong>
            </h1>
        @endCan
    </div>
    
    <div class="col-lg-3">
        <strong>Custom Form:</strong> {{ $inventory->custom_form?->name }}
    </div>
    
    <div class="col-lg-3">
        <strong>Variant options:</strong> {{ $inventory->variant_options }}
    </div>
    
    <div class="col-lg-12 mt-3">
        @can('update-ss-custom-form')
            <a href="{{ action([\App\Http\Controllers\SquarespaceCustomFormController::class, 'edit'], $inventory->id) }}"
                class="btn btn-info">{!! Html::image('images/edit.png', 'Edit', ['title' => 'Edit']) !!}</a>
        @endcan
        @can('delete-ss-custom-form')
            {{ html()->form('DELETE', route('inventory.destroy', [$inventory->id]))->attribute('onsubmit', 'return ConfirmDelete()')->class('d-inline')->open() }}
            {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
            {{ html()->form()->close() }}
        @endcan

    </div>
</div>
@stop