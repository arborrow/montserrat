@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Relationship Type</strong></h2>
        {{ html()->form('POST', url('relationship_type'))->class('form-horizontal panel')->open() }}
        <span>
            <div class='row'>
                {{ html()->label('Name A-B:', 'name_a_b')->class('col-md-1') }}
                {{ html()->text('name_a_b')->class('col-md-3') }}

                {{ html()->label('Label A-B:', 'label_a_b')->class('col-md-1') }}
                {{ html()->text('label_a_b')->class('col-md-3') }}
            
                {{ html()->label('Contact Type A:', 'contact_type_a')->class('col-md-2') }}
                {{ html()->select('contact_type_a', $contact_types, 'Individual')->class('col-md-1') }}            
            </div>
            <div class='row'>
                {{ html()->label('Name B-A:', 'name_b_a')->class('col-md-1') }}
                {{ html()->text('name_b_a')->class('col-md-3') }}

                {{ html()->label('Label B-A:', 'label_b_a')->class('col-md-1') }}
                {{ html()->text('label_b_a')->class('col-md-3') }}

                {{ html()->label('Contact Type B:', 'contact_type_b')->class('col-md-2') }}
                {{ html()->select('contact_type_b', $contact_types, 'Individual')->class('col-md-1') }}
            </div>
            <div class='row'>
                {{ html()->label('Description:', 'description')->class('col-md-1') }}
                {{ html()->textarea('description')->class('col-md-3') }}                   
            </div>             
            <div class="form-group">
                {{ html()->label('Active:', 'is_active')->class('col-md-1') }}
                {{ html()->checkbox('is_active', false, 1)->class('col-md-1') }}
                {{ html()->label('Reserved:', 'is_reserved')->class('col-md-1') }}
                {{ html()->checkbox('is_reserved', false, 0)->class('col-md-1') }}
            </div>
        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {{ html()->submit('Add Relationship Type')->class('btn btn-primary') }}
            </div>
                {{ html()->form()->close() }}
        </div><div class="clearfix"> </div>
    </span>
    </div>
</section>
@stop