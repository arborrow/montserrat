@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $uom->unit_name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Unit of measure</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('uom.update', [$uom->id]))->open() }}
                {{ html()->hidden('id', $uom->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Type', 'type') }}
                                        {{ html()->select('type', $uom_types, $uom->type)->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Unit name', 'unit_name') }}
                                        {{ html()->text('unit_name', $uom->unit_name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Unit symbol', 'unit_symbol') }}
                                        {{ html()->text('unit_symbol', $uom->unit_symbol)->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Description', 'description') }}
                                        {{ html()->text('description', $uom->description)->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Active:', 'is_active')->class('col-md-2') }}
                                        {{ html()->checkbox('is_active', $uom->is_active, 1)->class('col-md-2') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                        </div>
                    </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
@stop
