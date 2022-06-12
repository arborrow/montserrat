@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $inventory->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>SquareSpace Inventory</h2>
            </div>
            <div class="col-lg-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['inventory.update', $inventory->id]]) !!}
                {!! Form::hidden('id', $inventory->id) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('name', 'Name:') !!}
                                        {!! Form::text('name', $inventory->name , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('custom_form_id', 'Custom Form:') !!}
                                        {!! Form::select('custom_form_id', $custom_forms, $inventory->custom_form_id, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {!! Form::label('variant_options', 'Variant options:') !!}
                                        {!! Form::number('variant_options', $inventory->variant_options, ['class' => 'form-control','step'=>'1']) !!}
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
