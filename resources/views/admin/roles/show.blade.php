@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>Role details: {{$role->name}}</h2>
                </span>                
            </div>
            
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Name: </strong>{{$role->name}}
                        <br /><strong>Display name: </strong>{{$role->display_name}}     
                        <br /><strong>Description: </strong>{{$role->description}}
                    
                </div>
            </div></div>
            
        <div class='row'>
            
        @if ($role->permissions->isEmpty())
            <p>This role has no permissions!</p>
        @else
            <table class="table"><caption><h2>This role has the following permissions</h2></caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Display name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($role->permissions as $permission)
                    <tr>
                        <td><a href="../../admin/permission/{{ $permission->id}}">{{ $permission->name }}</a></td>
                        <td>{{ $permission->display_name }}</td>
                        <td>{{ $permission->description }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
        </div>
        
        <div class='row'>
            
        @if ($role->users->isEmpty())
            <p>No users currently have this role!</p>
        @else
            <table class="table"><caption><h2>The following users have this role:</h2></caption>
                <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($role->users as $user)
                    <tr>
                        <td>{{ $user->name }} </a></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
        </div>
        
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('RolesController@edit', $role->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['admin.role.destroy', $role->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
        
    </div>
</section>
@stop