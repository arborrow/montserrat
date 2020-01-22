@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        @can('update-address')
            <h1>
                Address details: <strong><a href="{{url('/address/'.$address->id.'/edit')}}">{{ $address->id }}</a></strong>
            </h1>
        @else
            <h1>
                Address details: <strong>{{$address->id}}</strong>
            </h1>
        @endCan
    </div>
    <div class="col-12">
        <h5>Address 1: {{$address->street_address}}</h5>
        <h5>Address 2: {{$address->supplemental_address_1}}</h5>
        <h5>City: {{$address->city}}</h5>
        <h5>State: {{$address->state_province_id}}</h5>
        <h5>Country: {{$address->country_id}}</h5>
        <h5>Zip: {{$address->postal_code}}</h5>
        <h5>Is primary: {{$address->is_primary}}</h5>
    </div>
    <div class="col-12 mb-4">
        @can('update-address')
            <a href="{{ action('AddressController@edit', $address->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit address',array('title'=>"Edit address")) !!}</a>
        @endcan

        @can('delete-address')
            {!! Form::open(['method' => 'DELETE', 'route' => ['address.destroy', $address->id], 'onsubmit'=>'return ConfirmDelete()', 'class' => 'd-inline']) !!}
            {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete address']) !!}
            {!! Form::close() !!}
        @endcan



    </div>

</div>
@stop
