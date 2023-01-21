@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        {!! Form::open(['url' => 'relationship/add', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        {{ Form::hidden('relationship_type_id', $relationship_type->id) }}
        {{ Form::hidden('direction', $direction) }}
        @if ($direction == 'a')
            <h3>{{$primary_contact->full_name}} is {{$relationship_type->label_a_b}}:</h3><br />
            <div class='row'>
                {!! Form::label('contact_b_id', $relationship_type->name_b_a, ['class' => 'col-md-2 font-weight-bold'])  !!}
                {!! Form::select('contact_b_id', $contact_list, null, ['class' => 'col-md-3', 'autofocus'=>'autofocus']) !!}            
                {{ Form::hidden('contact_a_id', $primary_contact->id) }}
            </div>
        @else
            <h3>{{$primary_contact->full_name}} is {{$relationship_type->label_b_a}}:</h3><br />
            <div class='row'>
                {!! Form::label('contact_a_id', $relationship_type->name_a_b, ['class' => 'col-md-2 font-weight-bold'])  !!}
                {!! Form::select('contact_a_id', $contact_list, null, ['class' => 'col-md-3', 'autofocus'=>'autofocus']) !!}            
                {{ Form::hidden('contact_b_id', $primary_contact->id) }}
            </div>
        @endIf
        <div class="clearfix"> </div>
        <br />
        <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Relationship '.$relationship_type->description, ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@stop