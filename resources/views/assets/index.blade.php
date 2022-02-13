@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Assets
            @can('create-asset')
            <span class="options">
                <a href={{ action([\App\Http\Controllers\AssetController::class, 'create']) }}>
                    <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                </a>
            </span>
            @endCan
            <a href={{ action([\App\Http\Controllers\AssetController::class, 'search']) }}>
                {!! Html::image('images/search.png', 'Search assets',array('title'=>"Search assets",'class' => 'btn btn-link')) !!}
            </a>

        </h2>
    </div>
    <div class="col-md-3 col-lg-6">
        <select class="type-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="">Filter by type ...</option>
            <option value="{{url('asset')}}">All assets</option>
            @foreach($asset_types as $key=>$type)
            <option value="{{url('asset/type/'.$key)}}">{{$type}}</option>
            @endForeach
        </select>
    </div>
    <div class="col-md-3 col-lg-6">
        <select class="location-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="">Filter by location ...</option>
            <option value="{{url('asset')}}">All locations</option>
            @foreach($locations as $key=>$location)
            <option value="{{url('asset/location/'.$key)}}">{{$location}}</option>
            @endForeach
        </select>
    </div>
    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($assets->isEmpty())
        <div class="col-lg-12 text-center py-5">
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
                    <td><a href="{{ url('asset/type/'.$asset->asset_type_id) }}">{{ $asset->asset_type_name }}</a></td>
                    @if ($asset->location_id > 0)
                    <td><a href="{{ url('asset/location/'.$asset->location_id) }}">{{ $asset->location_name }}</a></td>
                    @else
                    <td>{{ $asset->location_name }}</td>
                    @endIf
                    <td>{{ $asset->status }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
