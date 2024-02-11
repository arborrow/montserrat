@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-permission')
            <h1>
                Permission details: <strong><a href="{{url('admin/permission/'.$permission->id.'/edit')}}">{{ $permission->name }}</a></strong>
            </h1>
        @else
            <h1>
                Permission details: <strong>{{$permission->name}}</strong>
            </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <h5>Name: {{$permission->name}}</h5>
        <h5>Display name: {{$permission->display_name}}</h5>
        <h5>Description: {{$permission->description}}</h5>
    </div>
    <div class="col-lg-12">
        @can('manage-permission')
            {{ html()->form('POST', route('admin.permission.update_roles', ))->open() }}
                <div class="form-group">
                    {{ html()->hidden('id', $permission->id) }}
                    {{ html()->label('Assigned roles:', 'roles') }}
                    {{ html()->multiselect('roles[]', $roles, $permission->roles->pluck('id')->toArray())->id('roles')->class('form-control select2') }}
                    {{ html()->submit('Update role assignments')->class('btn btn-outline-dark mt-3') }}
                </div>
            {{ html()->form()->close() }}
        @endCan
    </div>
    <div class="col-lg-12">Users with {{ $permission->name }} permission:
        <ul>
            @foreach($permission->roles as $role)
                @foreach($role->users as $user)
                    <li><a href = "{{ URL('admin/user/' . $user->id) }}">{{ $user->name }}</a>
                @endforeach
            @endforeach
        </ul>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6 text-right">
                <a href="{{ action([\App\Http\Controllers\PermissionController::class, 'edit'], $permission->id) }}" class="btn btn-info">
                    {{ html()->img(asset('images/edit.png'), 'Edit')->attribute('title', "Edit") }}
                </a>
            </div>
            <div class="col-lg-6 text-left">
                {{ html()->form('DELETE', route('permission.destroy', [$permission->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                {{ html()->form()->close() }}</div><div class="clearfix">
            </div>
        </div>
    </div>
</div>
@stop
