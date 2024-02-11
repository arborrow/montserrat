@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create Squarespace Custom Form Field</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'admin/squarespace/custom_form/' . $custom_form->id . '/store')->open() }}
        {{ html()->hidden('id', $custom_form->id) }}
        {{ html()->hidden('form_id', $custom_form->id) }}
            <div class="form-group">
                <h2>Custom Form: {{ $custom_form->name }}</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Name', 'name') }}
                        {{ html()->text('name')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Type', 'type') }}
                        {{ html()->text('type')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Variable name', 'variable_name') }}
                        {{ html()->text('variable_name')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Sort order', 'sort_order') }}
                        {{ html()->text('sort_order')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add Custom Form')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
