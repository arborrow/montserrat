@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Add a {{$relationship_type->description}} Relationship</strong></h2>
        <br />
        {!! Form::open(['url' => 'relationship/add', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        {{ Form::hidden('relationship_type_id', $relationship_type->id) }}
        {{ Form::hidden('direction', $direction) }}
        <span>
            <div class='row'>
                {!! Form::label('contact_a_id', $relationship_type->name_a_b, ['class' => 'col-md-2 font-weight-bold'])  !!}
                @if ($direction == 'a')
                    {!! Form::select('contact_a_id', $contact_a_list, 'Individual', ['class' => 'col-md-3 bg-success']) !!}            
                @else
                    {!! Form::select('contact_a_id', $contact_a_list, 'Individual', ['class' => 'col-md-3', 'autofocus'=>'autofocus']) !!}            
                @endIf
            </div>
            <br />
            <div class='row'>
                {!! Form::label('contact_b_id', $relationship_type->name_b_a, ['class' => 'col-md-2 font-weight-bold'])  !!}
                @if ($direction == 'b')
                    {!! Form::select('contact_b_id', $contact_b_list, 'Individual', ['class' => 'col-md-3 bg-success']) !!}
                @else
                    {!! Form::select('contact_b_id', $contact_b_list, 'Individual', ['class' => 'col-md-3', 'autofocus'=>'autofocus']) !!}
                @endIf
            </div>
            <div class="clearfix"> </div>
            <br />
            <div class="col-md-1">
                <div class="form-group">
                    {!! Form::submit('Add '.$relationship_type->description, ['class'=>'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </span>
    </div>
</section>
@stop