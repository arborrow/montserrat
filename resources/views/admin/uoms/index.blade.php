@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>
            Units of measure
            @can('create-uom')
                <span class="options">
                    <a href={{ action('UomController@create') }}>
                        <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
    </div>
    <div class="col-12 my-3 table-responsive-md">
        @if ($uoms->isEmpty())
            <div class="col-12 text-center py-5">
                <p>It is a brand new world, there are no units of measure!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Unit name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Unit symbol</th>
                        <th scope="col">Description</th>
                        <th scope="col">Active</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uoms as $uom)
                    <tr>
                        <td><a href="{{URL('admin/uom/'.$uom->id)}}">{{ $uom->unit_name }}</a></td>
                        <td>{{ $uom->type }}</td>
                        <td>{{ $uom->unit_symbol }}</td>
                        <td>{{ $uom->description }}</td>
                        <td>{{ $uom->is_active ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
