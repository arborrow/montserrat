@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $custom_form->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Custom Form Field</h2>
            </div>
            <div class="col-lg-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['custom_form.update', $custom_form->id]]) !!}
                {!! Form::hidden('id', $custom_form->id) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', $custom_form->name , ['class' => 'form-control']) !!}
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
