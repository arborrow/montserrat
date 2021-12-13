@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Permissions
            @can('create-permission')
                <span class="options">
                    <a href={{ action('PermissionController@create') }}>
                        {!! Html::image('images/create.png', 'Add Permission',array('title'=>"Add Permission",'class' => 'btn btn-light')) !!}
                    </a>
                </span>
            @endcan
        </h1>
    </div>
    <div class="col-lg-12">
        @can('manage-permission')
            {!! Form::open(['url' => 'admin/permission', 'method' => 'GET', 'route' => ['admin.permission'], 'class' => 'form-inline']) !!}
                <div class="form-group mb-2 mx-2">
                    {!! Form::label('action', 'Action')  !!}
                    {!! Form::select('action', $actions, 0, ['id'=>'action','class' => 'form-control mx-1']) !!}
                </div>
                <div class="form-group mb-2 mx-2">
                    {!! Form::label('model', 'Model')  !!}
                    {!! Form::select('model', $models, 0, ['id'=>'model','class' => 'form-control mx-1']) !!}
                </div>
                <div class="form-group mb-2 mx-3">
                    {!! Form::submit('Search', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            {!! Form::close() !!}
        @endCan
    </div>
    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($permissions->isEmpty())
            <div class="col-lg-12 text-center py-5">
                <p>It is a brand new world, there are no permissions!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Display name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td><a href="permission/{{ $permission->id}}">{{ $permission->name }}</a></td>
                        <td>{{ $permission->display_name }}</td>
                        <td>{{ $permission->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop