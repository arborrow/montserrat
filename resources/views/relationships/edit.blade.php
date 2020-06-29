@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Relationship {{ $relationship->id }}</h1>
    {!! Form::open(['method' => 'PUT', 'route' => ['relationship.update', $relationship->id]]) !!}
    {!! Form::hidden('id', $relationship->id) !!}
    <div class="row">
        <div class="col-6">
            <strong>Contact A: {!! $relationship->contact_a->contact_link_full_name!!}</strong>
        </div>

        <div class="col-6">
            <strong>Contact B: {!! $relationship->contact_b->contact_link_full_name!!}</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            {!! Form::label('relationship_type_id', 'Type:')  !!}
            {!! Form::select('relationship_type_id', $relationship_types, $relationship->relationship_type_id, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            {!! Form::label('description', 'Description:', ['style' => 'vertical-align: top']) !!}
            {!! Form::textarea('description', $relationship->description, ['class' => 'col-md-6', 'rows'=>'3']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            {!! Form::label('start_date', 'Start date:') !!}
            {!! Form::date('start_date', $relationship->start_date, ['class'=>'form-control bg-white flatpickr-date']) !!}
        </div>

        <div class="col-6">
            {!! Form::label('end_date', 'End date:') !!}
            {!! Form::date('end_date', $relationship->end_date, ['class'=>'form-control bg-white flatpickr-date']) !!}
        </div>
    </div>

    <div class="row">

        <div class="form-check">
            {!! Form::checkbox('is_active', 1, $relationship->is_active,['class' => 'form-check-input']) !!}
            {!! Form::label('is_active', 'Active', ['class' => 'form-check-label']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-primary']) !!}
        </div>
    </div>
        {!! Form::close() !!}
</div>
@stop
