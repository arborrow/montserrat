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
            </div>
            <div class='row'>
                <div class='col-md-8'>
                        
                    @can('manage-permission')
                        {!! Form::open(['url' => 'admin/permission/update_roles', 'method' => 'POST', 'route' => ['admin.permission.update_roles']]) !!}
                        {!! Form::hidden('id',$permission->id) !!}
                        {!! Form::label('roles', 'Assigned roles:', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('roles[]', $roles, $permission->roles->pluck('id')->toArray(), ['id'=>'roles','class' => 'form-control col-md-6','multiple' => 'multiple']) !!}
                        Update role assignments {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-default']) !!}
                        {!! Form::close() !!}
                    @endCan
                </div>
                
            </div>
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