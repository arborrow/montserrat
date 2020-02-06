@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>
            Addresses
            @can('create-address')
                <span class="options">
                    <a href={{ action('AddressController@create') }}>
                        <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
    </div>
    <div class="col-12 my-3 table-responsive-md">
        @if ($addresses->isEmpty())
            <div class="col-12 text-center py-5">
                <p>It is a brand new world, there are no addresses!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Address 1</th>
                        <th scope="col">Address 2</th>
                        <th scope="col">City</th>
                        <th scope="col">State</th>
                        <th scope="col">Zip</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addresses as $address)
                    <tr>
                        <td>{{ $address->id }}</td>
                        <td>{!! $address->addressee->contact_link_full_name !!}</td>
                        <td>{{ $address->location_type_id }}</td>
                        <td>{{ $address->street_address }}</td>
                        <td>{{ $address->supplemental_address_1 }}</td>
                        <td>{{ $address->city }}</td>
                        <td>{{ $address->state_province_id }}</td>
                        <td>{{ $address->postal_code}}</td>
                    </tr>
                    @endforeach
                    {!! $addresses->render() !!}
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop