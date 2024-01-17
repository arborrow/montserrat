@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Group:</strong></h2></span>

    {{ html()->form('PUT', route('group.update', [$group->id]))->open() }}
    {{ html()->hidden('id', $group->id) }}
    
        <span><h2>Group details</h2>
            <div class="form-group">
                <div class='row'>
                    {{ html()->label('Name:', 'name')->class('col-md-3') }}

                    {{ html()->text('name', $group->name)->class('col-md-3') }}
                </div>
                <div class='row'>
                    {{ html()->label('Title:', 'title')->class('col-md-3') }}

                    {{ html()->text('title', $group->title)->class('col-md-3') }}
                </div>
                <div class='row'>
                    {{ html()->label('Description:', 'description')->class('col-md-3') }}
                    {{ html()->textarea('description', $group->description)->class('col-md-3') }}                   
                </div>             
                <div class="form-group">
                    {{ html()->label('Active:', 'is_active')->class('col-md-1') }}
                    {{ html()->checkbox('is_active', $group->is_active, 1)->class('col-md-1') }}
                    {{ html()->label('Hidden:', 'is_hidden')->class('col-md-1') }}
                    {{ html()->checkbox('is_hidden', $group->is_hidden, 1)->class('col-md-1') }}
                    {{ html()->label('Reserved:', 'is_reserved')->class('col-md-1') }}
                    {{ html()->checkbox('is_reserved', $group->is_reserved, 1)->class('col-md-1') }}
                </div>
                <div class="clearfix"> </div>
    
            </div>
        </span>
                
    <div class="clearfix"> </div>
    <div class="form-group">
        {{ html()->input('image', 'btnSave')->class('btn btn-primary')->attribute('src', asset('images/save.png')) }}
    </div>
    {{ html()->form()->close() }}
</div>
@stop