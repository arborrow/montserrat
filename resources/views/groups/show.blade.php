@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2><strong>
                        @can('update-group')
                            {!! Html::link(url('group/'.$group->id.'/edit'),$group->name.' group') !!} 
                        @else
                            {{$group->name}} group
                        @endCan
                        </strong></h2>
                </span>
                @can('create-touchpoint')
                    <span class="btn btn-default">
                        <a href={{ action('TouchpointController@add_group',$group->id) }}>Add Group Touchpoint</a>
                    </span>
                @endCan
                @can('create-registration')
                    <span class="btn btn-default">
                        <a href={{ action('RegistrationController@add_group',$group->id) }}>Add Group Registration</a>
                    </span>
                @endCan
            </div>
            <div class="clearfix"> </div>
                
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Name: </strong>{{$group->name}}
                        <br /><strong>Title: </strong>{{$group->title}}  
                        <br /><strong>Description: </strong>{{$group->description}}     
                        <br /><strong>Active: </strong>{{$group->is_active}}
                        <br /><strong>Hidden: </strong>{{$group->is_hidden}}
                        <br /><strong>Reserved: </strong>{{$group->is_reserved}}
                    
                </div>
            </div>
            <div class="clearfix"> </div>
            <div class="panel-heading">
                <span>
                    <h2><strong>Members of the {{$group->name}} Group</strong></h2>
            </div>
            <div class='row'>
                <div class="col-md-4 scroll">
                    @foreach($members as $member)
                        {!!$member->contact_link_full_name !!}<br />
                    @endforeach
                </div>
            </div>
            
            <div class="clearfix"> </div>
        </div>
        
        <div class='row'>
            @can('update-group')
                <div class='col-md-1'>
                    <a href="{{ action('GroupController@edit', $group->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                </div>
            @endCan
            @can('delete-group')
                <div class='col-md-1'>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['group.destroy', $group->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                    {!! Form::close() !!}
                </div>
            @endCan
            <div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop