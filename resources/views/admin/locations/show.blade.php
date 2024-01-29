@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-location')
        <h1>
            Location details: <strong><a href="{{url('admin/location/'.$location->id.'/edit')}}">{{ $location->name }}</a></strong>
        </h1>
        @else
        <h1>
            Location details: <strong>{{$location->name}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <span class="font-weight-bold">Label: </span> {{$location->label}}<br />
        <span class="font-weight-bold">Description: </span> {{$location->description}}<br />
        <span class="font-weight-bold">Type: </span> {{$location->type}}<br />
        <span class="font-weight-bold">Occupancy: </span> {{$location->occupancy}}<br />
        <span class="font-weight-bold">Notes: </span> {{$location->notes}}<br />
        <span class="font-weight-bold">Latitude/Longitude: </span> {{$location->latitude}} / {{$location->longitude}}<br />
        @if (! empty($location->parent_id))
            <span class="font-weight-bold">Parent: </span> <a href = "{{URL('admin/location/'.$location->parent_id)}}">{{$location->parent_name}}</a><br />
        @else
            <span class="font-weight-bold">Parent: </span> Unspecified<br />
        @endIf
    </div>

    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($children->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>This location does not have any sub-locations</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <caption>Sub-locations</caption>
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
                @foreach($children as $child)
                <tr>
                    <td><a href="{{URL('admin/location/'.$child->id)}}">{{ $child->name }}</a></td>
                    <td>{{ $child->description }}</td>
                    <td>{{ $child->type }}</td>
                    <td>{{ $child->occupancy }}</td>
                    <td>{{ $child->notes }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>

    <br />

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-location')
                    <a href="{{ action([\App\Http\Controllers\LocationController::class, 'edit'], $location->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-location')
                    {{ html()->form('DELETE', route('location.destroy', [$location->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                    {{ html()->form()->close() }}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
