@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    @can('update-role')
                        <h2>
                            Role details: <strong><a href="{{url('admin/role/'.$role->id.'/edit')}}">{{ $role->name }}</a></strong>
                        </h2>
                    @else
                        <h2>
                            Role details: <strong>{{$role->name}}</strong>
                        </h2>
                    @endCan
                </span>                
            </div>
            
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Name: </strong>{{$role->name}}
                        <br /><strong>Display name: </strong>{{$role->display_name}}     
                        <br /><strong>Description: </strong>{{$role->description}}
                    
                </div>
            </div>
            <div class="clearfix"> </div>
<hr />
            <div class='row'>
                <div class='col-md-8'>
                
                    @can('manage-permission')
                        {!! Form::open(['url' => 'admin/role/update_permissions', 'method' => 'POST', 'route' => ['role.update_permissions']]) !!}
                        {!! Form::hidden('id',$role->id) !!}
                        {!! Form::label('permissions', 'Permissions granted to '.$role->name.' role:', ['class' => 'col-md-4'])  !!}
                        {!! Form::select('permissions[]', $permissions, $role->permissions->pluck('id')->toArray(), ['id'=>'permissions','class' => 'form-control col-md-6','multiple' => 'multiple']) !!}
                        Update permissions {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-default']) !!}
                        {!! Form::close() !!}
                    @endCan
                </div>
            </div>
<hr />
            <div class='row'>
                <div class='col-md-8'>

                    @can('manage-permission')
                        {!! Form::open(['url' => 'admin/role/update_users', 'method' => 'POST', 'route' => ['role.update_users']]) !!}
                        {!! Form::hidden('id',$role->id) !!}
                        {!! Form::label('users', 'Users with '.$role->name.' role:', ['class' => 'col-md-4'])  !!}
                        {!! Form::select('users[]', $users, $role->users->pluck('id')->toArray(), ['id'=>'users','class' => 'form-control col-md-6','multiple' => 'multiple']) !!}
                        Update users {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-default']) !!}
                        {!! Form::close() !!}
                    @endCan

                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-1'><a href="{{ action('RolesController@edit', $role->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
            <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['role.destroy', $role->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop