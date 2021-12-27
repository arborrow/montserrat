@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $donation_type->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Donation type</h2>
            </div>
            <div class="col-lg-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['donation_type.update', $donation_type->id]]) !!}
                {!! Form::hidden('id', $donation_type->id) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('name', 'Name')  !!}
                                        {!! Form::text('name', $donation_type->name, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('label', 'Label')  !!}
                                        {!! Form::text('label', $donation_type->label, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('value', 'Value')  !!}
                                        {!! Form::text('value', $donation_type->value, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('description', 'Description')  !!}
                                        {!! Form::text('description', $donation_type->description, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('is_active', 'Active:', ['class' => 'col-md-2'])  !!}
                                        {!! Form::checkbox('is_active', 1, $donation_type->is_active,['class' => 'col-md-2']) !!}
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
