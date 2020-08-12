@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>
            Donation types
            @can('create-donation-type')
                <span class="options">
                    <a href={{ action('DonationTypeController@create') }}>
                        <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
    </div>
    <div class="col-12 my-3 table-responsive-md">
        @if ($donation_types->isEmpty())
            <div class="col-12 text-center py-5">
                <p>It is a brand new world, there are no donation types!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Label</th>
                        <th scope="col">Value</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Active</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donation_types as $donation_type)
                    <tr>
                        <td><a href="donation_type/{{ $donation_type->id}}">{{ $donation_type->label }}</a></td>
                        <td>{{ $donation_type->value }}</td>
                        <td>{{ $donation_type->name }}</td>
                        <td>{{ $donation_type->description }}</td>
                        <td>{{ $donation_type->is_active ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
