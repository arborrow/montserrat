@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
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
    <div class="col-12">
        <h5>Name: {{$permission->name}}</h5>
        <h5>Display name: {{$permission->display_name}}</h5>
        <h5>Description: {{$permission->description}}</h5>
    </div>
    <div class="col-12">
        @can('manage-permission')
            {!! Form::open(['url' => 'admin/permission/update_roles', 'method' => 'POST', 'route' => ['admin.permission.update_roles']]) !!}
                <div class="form-group">
                    {!! Form::hidden('id', $permission->id) !!}
                    {!! Form::label('roles', 'Assigned roles:')  !!}
                    {!! Form::select('roles[]', $roles, $permission->roles->pluck('id')->toArray(), ['id'=>'roles','class' => 'form-control select2','multiple' => 'multiple']) !!}
                    {!! Form::submit('Update role assignments', ['class' => 'btn btn-outline-dark mt-3']) !!}
                </div>
            {!! Form::close() !!}
        @endCan
    </div>
    <div class="col-12">Users with {{ $permission->name }} permission:
        <ul>
            @foreach($permission->roles as $role)
                @foreach($role->users as $user)
                    <li><a href = "{{ URL('admin/user/' . $user->id) }}">{{ $user->name }}</a>
                @endforeach
            @endforeach
        </ul>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-6 text-right">
                <a href="{{ action('PermissionController@edit', $permission->id) }}" class="btn btn-info">
                    {!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}
                </a>
            </div>
            <div class="col-6 text-left">
                {!! Form::open(['method' => 'DELETE', 'route' => ['permission.destroy', $permission->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}</div><div class="clearfix">
            </div>
        </div>
    </div>
</div>
@stop
