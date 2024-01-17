@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create unit of measure</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'admin/uom')->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Unit name', 'unit_name') }}
                        {{ html()->text('unit_name')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Type', 'type') }}
                        {{ html()->select('type', $uom_types)->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Unit symbol', 'unit_symbol') }}
                        {{ html()->text('unit_symbol')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Description', 'description') }}
                        {{ html()->textarea('description')->class('form-control')->rows(3) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Active:', 'is_active')->class('col-md-1') }}
                        {{ html()->checkbox('is_active', true, 1)->class('col-md-1') }}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add unit of measure')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
