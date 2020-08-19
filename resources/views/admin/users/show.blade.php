@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
            <h1>
                User details for <strong>{{$user->name}}</strong>
            </h1>
    </div>
    <div class="col-12">
        Avatar: <img src="{{$user->avatar}}">
        <h5>Name: {{$user->name}}</h5>
        <h5>Email: {{$user->email}}</h5>
    </div>
    <table class="table table-bordered table-striped table-hover table-responsive-md">
        <caption><h2>Roles and Permissions</h2</caption>
        <th>Role name</th>
        <th>Permissions</th>
            @foreach($user->roles as $role)
                <tr>
                    <td>
                        <a href = "{{ URL('admin/role/'.$role->id) }}">
                            {{ $role->name }}
                        </a>
                    </td>
                    <td>
                        @foreach($role->permissions as $permission)
                                @if ($loop->last)
                                    <a href = {{ URL('admin/permission/' . $permission->id) }}>
                                        {{ $permission->name }}
                                    </a>
                                @else
                                    <a href = {{ URL('admin/permission/' . $permission->id) }}>
                                        {{ $permission->name }}
                                    </a>,
                                @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
    </table>
</div>
@stop
