@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create Squarespace Inventory</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url'=>'admin/squarespace/inventory/', 'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('custom_form_id', 'Custom Form:') !!}
                        {!! Form::select('custom_form_id', $custom_forms, null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('variant_options', 'Variant options:') !!}
                        {!! Form::number('variant_options', 0, ['class' => 'form-control','step'=>'1']) !!}
                    </div>


                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::submit('Add Squarespace Inventory', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop