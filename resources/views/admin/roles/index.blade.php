@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Roles
            @can('create-role')
                <span class="options">
                    <a href={{ action('RoleController@create') }}>
                        <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
    </div>
    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($roles->isEmpty())
            <div class="col-lg-12 text-center py-5">
                <p>It is a brand new world, there are no roles!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Display name</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td><a href="role/{{ $role->id}}">{{ $role->name }}</a></td>
                        <td>{{ $role->display_name }}</td>
                        <td>{{ $role->description }}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop