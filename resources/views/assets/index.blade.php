@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>
            Assets
            @can('create-asset')
                <span class="options">
                    <a href={{ action('AssetController@create') }}>
                        <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
    </div>
    <div class="col-12 my-3 table-responsive-md">
        @if ($assets->isEmpty())
            <div class="col-12 text-center py-5">
                <p>It is a brand new world, there are no asset!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Manufacturer</th>
                        <th scope="col">Model</th>
                        <th scope="col">Type</th>
                        <th scope="col">Location</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                    <tr>
                        <td><a href="{{URL('asset/'.$asset->id)}}">{{ $asset->name }}</a></td>
                        <td>{{ $asset->manufacturer }}</td>
                        <td>{{ $asset->model }}</td>
                        <td>{{ $asset->asset_type_name }}</td>
                        <td>{{ $asset->location_name }}</td>
                        <td>{{ $asset->status }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
