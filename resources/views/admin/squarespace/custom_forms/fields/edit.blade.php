@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit SquareSpace Custom Field: {{ $custom_form_field->name .' (' . $custom_form_field->form->name .')' }}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['custom_form.field.update', $custom_form_field->id]]) !!}
                {!! Form::hidden('id', $custom_form_field->id) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', $custom_form_field->name , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('type', 'Type') !!}
                                        {!! Form::text('type', $custom_form_field->type , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('sort_order', 'Sort order') !!}
                                        {!! Form::text('sort_order', $custom_form_field->sort_order , ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
