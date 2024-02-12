@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Group</strong></h2>
        {{ html()->form('POST', url('group'))->class('form-horizontal panel')->open() }}
        <span>
            <div class='row'>
                {{ html()->label('Name:', 'name')->class('col-md-3') }}

                {{ html()->text('name')->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Title:', 'title')->class('col-md-3') }}

                {{ html()->text('title')->class('col-md-3') }}
            </div>
            <div class='row'>
                {{ html()->label('Description:', 'description')->class('col-md-3') }}
                {{ html()->textarea('description')->class('col-md-3') }}                   
            </div>             
            <div class="form-group">
                {{ html()->label('Active:', 'is_active')->class('col-md-1') }}
                {{ html()->checkbox('is_active', true, 1)->class('col-md-1') }}
                {{ html()->label('Hidden:', 'is_hidden')->class('col-md-1') }}
                {{ html()->checkbox('is_hidden', false, 0)->class('col-md-1') }}
                {{ html()->label('Reserved:', 'is_reserved')->class('col-md-1') }}
                {{ html()->checkbox('is_reserved', false, 0)->class('col-md-1') }}
            </div>
                    
        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {{ html()->submit('Add Group')->class('btn btn-primary') }}
            </div>
                {{ html()->form()->close() }}
        </div>
        <div class="clearfix"> </div>
    </span>
    </div>
</section>
@stop