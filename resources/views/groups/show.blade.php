@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2><strong>
                        @can('update-group')
                            {{ html()->a(url('group/' . $group->id . '/edit'), $group->name . ' group') }} 
                        @else
                            {{$group->name}} group
                        @endCan
                        </strong></h2>
                </span>
                @can('create-touchpoint')
                    <span class="btn btn-outline-dark">
                        <a href={{ action([\App\Http\Controllers\TouchpointController::class, 'add_group'],$group->id) }}>Add Group Touchpoint</a>
                    </span>
                @endCan
                @can('create-registration')
                    <span class="btn btn-outline-dark">
                        <a href={{ action([\App\Http\Controllers\RegistrationController::class, 'add_group'],$group->id) }}>Add Group Registration</a>
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
                    <a href="{{ action([\App\Http\Controllers\GroupController::class, 'edit'], $group->id) }}" class="btn btn-info">{{ html()->img(asset('images/edit.png'), 'Edit')->attribute('title', "Edit") }}</a>
                </div>
            @endCan
            @can('delete-group')
                <div class='col-md-1'>
                    {{ html()->form('DELETE', route('group.destroy', [$group->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }} 
                    {{ html()->form()->close() }}
                </div>
            @endCan
            <div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop