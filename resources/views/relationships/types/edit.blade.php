@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Relationship Type</strong></h2></span>

    {{ html()->form('PUT', route('relationship_type.update', [$relationship_type->id]))->open() }}
    {{ html()->hidden('id', $relationship_type->id) }}
    
        <span><h2>Relationship Type Details</h2>
            <div class="form-group">
                 <div class='row'>
                    {{ html()->label('Name A-B:', 'name_a_b')->class('col-md-1') }}

                    {{ html()->text('name_a_b', $relationship_type->name_a_b)->class('col-md-3') }}
                    {{ html()->label('Label A-B:', 'label_a_b')->class('col-md-1') }}

                    {{ html()->text('label_a_b', $relationship_type->label_a_b)->class('col-md-3') }}
                </div>
                <div class='row'>
                    {{ html()->label('Name B-A:', 'name_b_a')->class('col-md-1') }}

                    {{ html()->text('name_b_a', $relationship_type->name_b_a)->class('col-md-3') }}
                    {{ html()->label('Label B-A:', 'label_b_a')->class('col-md-1') }}

                    {{ html()->text('label_b_a', $relationship_type->label_b_a)->class('col-md-3') }}
                </div>
                <div class='row'>
                    {{ html()->label('Description:', 'description')->class('col-md-1') }}
                    {{ html()->textarea('description', $relationship_type->description)->class('col-md-3') }}                   
                </div>             
                <div class="form-group">
                    {{ html()->label('Active:', 'is_active')->class('col-md-1') }}
                    {{ html()->checkbox('is_active', $relationship_type->is_active, true)->class('col-md-1') }}
                    {{ html()->label('Reserved:', 'is_reserved')->class('col-md-1') }}
                    {{ html()->checkbox('is_reserved', $relationship_type->is_reserved, false)->class('col-md-1') }}
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