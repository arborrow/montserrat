@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Relationship Type</strong></h2>
        {!! Form::open(['url' => 'relationship_type', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <span>
            <div class='row'>
                {!! Form::label('name_a_b', 'Name A-B:', ['class' => 'col-md-1'])  !!}
                {!! Form::text('name_a_b', null, ['class' => 'col-md-3']) !!}

                {!! Form::label('label_a_b', 'Label A-B:', ['class' => 'col-md-1'])  !!}
                {!! Form::text('label_a_b', null, ['class' => 'col-md-3']) !!}
            
                {!! Form::label('contact_type_a', 'Contact Type A:', ['class' => 'col-md-2'])  !!}
                {!! Form::select('contact_type_a', $contact_types, 'Individual', ['class' => 'col-md-1']) !!}            
            </div>
            <div class='row'>
                {!! Form::label('name_b_a', 'Name B-A:', ['class' => 'col-md-1'])  !!}
                {!! Form::text('name_b_a', null, ['class' => 'col-md-3']) !!}

                {!! Form::label('label_b_a', 'Label B-A:', ['class' => 'col-md-1'])  !!}
                {!! Form::text('label_b_a', null, ['class' => 'col-md-3']) !!}

                {!! Form::label('contact_type_b', 'Contact Type B:', ['class' => 'col-md-2'])  !!}
                {!! Form::select('contact_type_b', $contact_types, 'Individual', ['class' => 'col-md-1']) !!}
            </div>
            <div class='row'>
                {!! Form::label('description', 'Description:', ['class' => 'col-md-1'])  !!}
                {!! Form::textarea('description', NULL, ['class' => 'col-md-3']) !!}                   
            </div>             
            <div class="form-group">
                {!! Form::label('is_active', 'Active:', ['class' => 'col-md-1'])  !!}
                {!! Form::checkbox('is_active', 1, false,['class' => 'col-md-1']) !!}
                {!! Form::label('is_reserved', 'Reserved:', ['class' => 'col-md-1'])  !!}
                {!! Form::checkbox('is_reserved', 0, false,['class' => 'col-md-1']) !!}
            </div>
        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Relationship Type', ['class'=>'btn btn-primary']) !!}
            </div>
                {!! Form::close() !!}
        </div><div class="clearfix"> </div>
    </span>
    </div>
</section>
@stop