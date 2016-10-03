@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>Permission details: {{$permission->name}}</h2>
                </span>                
            </div>
            
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Name: </strong>{{$permission->name}}
                        <br /><strong>Display name: </strong>{{$permission->display_name}}     
                        <br /><strong>Description: </strong>{{$permission->description}}
                    
                </div>
            </div></div>
         <div class='row'>
            
        @if ($permission->roles->isEmpty())
            <p>This permission is not assigned to any roles!</p>
        @else
            <table class="table"><caption><h2>This permission is assigned to the following roles:</h2></caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Display name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permission->roles as $role)
                    <tr>
                        <td><a href="../../admin/role/{{ $role->id}}">{{ $role->name }}</a></td>
                        <td>{{ $role->display_name }}</td>
                        <td>{{ $role->description }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
        </div>
       
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('PermissionsController@edit', $permission->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['admin.permission.destroy', $permission->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
        
    </div>
</section>
@stop