@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
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
    <div class="col-lg-12">
        <h5>Contact: {!! $address->addressee->contact_link_full_name !!} </h5>
        <h5>Location type: {{ $address->location_type_name }} </h5>
        <h5>Address 1: {{$address->street_address}} </h5>
        <h5>Address 2: {{$address->supplemental_address_1}} </h5>
        <h5>City: {{$address->city}} </h5>
        <h5>State: {{$address->state_name}} </h5>
        <h5>Country: {{$address->country_name}} </h5>
        <h5>Zip: {{$address->postal_code}} </h5>
        <h5>Is primary: {{ $address->is_primary ? 'Yes':'No'}} </h5>
    </div>
    <div class="col-lg-6 mt-4 mb-4">
        @can('update-address')
            <a href="{{ action('AddressController@edit', $address->id) }}" class="btn btn-info mr-4">
              {!! Html::image('images/edit.png', 'Edit address',array('title'=>"Edit address")) !!}
            </a>
        @endcan
    
        @can('delete-address')
            {!! Form::open(['method' => 'DELETE', 'route' => ['address.destroy', $address->id], 'onsubmit'=>'return ConfirmDelete()', 'class' => 'd-inline']) !!}
            {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete address']) !!}
            {!! Form::close() !!}
        @endcan

    </div>

</div>
@stop
