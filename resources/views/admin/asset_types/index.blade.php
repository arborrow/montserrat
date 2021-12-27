@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Asset types
            @can('create-asset-type')
                <span class="options">
                    <a href={{ action('AssetTypeController@create') }}>
                        <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
    </div>
    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($asset_types->isEmpty())
            <div class="col-lg-12 text-center py-5">
                <p>It is a brand new world, there are no asset types!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Label</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Active</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asset_types as $asset_type)
                    <tr>
                        <td><a href="{{URL('admin/asset_type/'.$asset_type->id)}}">{{ $asset_type->label }}</a></td>
                        <td>{{ $asset_type->name }}</td>
                        <td>{{ $asset_type->description }}</td>
                        <td>{{ $asset_type->is_active ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
