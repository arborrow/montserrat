@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Locations
            @can('create-location')
            <span class="options">
                <a href={{ action('LocationController@create') }}>
                    <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                </a>
            </span>
            @endCan
        </h2>
    </div>
        <div class="col-md-2 col-lg-12">
            <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="">Filter by type ...</option>
                <option value="{{url('admin/location')}}">All locations</option>
                @foreach($location_types as $key=>$type)
                <option value="{{url('admin/location/type/'.$key)}}">{{$type}}</option>
                @endForeach
            </select>
        </div>

    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($locations->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>It is a brand new world, there are no locations!</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Type</th>
                    <th scope="col">Occupancy</th>
                    <th scope="col">Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                <tr>
                    <td><a href="{{URL('admin/location/'.$location->id)}}">{{ $location->name }}</a></td>
                    <td>{{ $location->description }}</td>
                    <td>{{ $location->type }}</td>
                    <td>{{ $location->occupancy }}</td>
                    <td>{{ $location->notes }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
