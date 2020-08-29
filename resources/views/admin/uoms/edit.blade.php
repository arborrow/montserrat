@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit: {!! $uom->unit_name !!}</h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <h2>Unit of measure</h2>
            </div>
            <div class="col-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['uom.update', $uom->id]]) !!}
                {!! Form::hidden('id', $uom->id) !!}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('type', 'Type')  !!}
                                        {!! Form::select('type', $uom_types, $uom->type, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('unit_name', 'Unit name')  !!}
                                        {!! Form::text('unit_name', $uom->unit_name, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('unit_symbol', 'Unit symbol')  !!}
                                        {!! Form::text('unit_symbol', $uom->unit_symbol, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('description', 'Description')  !!}
                                        {!! Form::text('description', $uom->description, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('is_active', 'Active:', ['class' => 'col-md-2'])  !!}
                                        {!! Form::checkbox('is_active', 1, $uom->is_active,['class' => 'col-md-2']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
