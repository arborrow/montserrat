@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Permissions Index</span> 
                    <span class="create"><a href={{ action('PermissionController@create') }}>{!! Html::image('img/create.png', 'Add Permission',array('title'=>"Add Permission",'class' => 'btn btn-primary')) !!}</a></span></h1>
                
                </div>
                @can('manage-permission')
                        {!! Form::open(['url' => 'admin/permission', 'method' => 'GET', 'route' => ['admin.permission']]) !!}
                        {!! Form::label('action', 'Actions:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('action', $actions, 0, ['id'=>'action','class' => 'form-control col-md-6']) !!}
                        {!! Form::label('model', 'Models:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('model', $models, 0, ['id'=>'model','class' => 'form-control col-md-6']) !!}
                        {!! Form::submit() !!}
                        {!! Form::close() !!}
                @endCan
                @if ($permissions->isEmpty())
                    <p>It is a brand new world, there are no permissions!</p>
                @else
                <table class="table"><caption><h2>Permissions</h2></caption>
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
    </section>
@stop