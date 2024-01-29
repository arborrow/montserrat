@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit Squarespace Custom Field: {{ $custom_form_field->name .' (' . $custom_form_field->form->name .')' }}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                {{ html()->form('PUT', route('custom_form.field.update', [$custom_form_field->id]))->open() }}
                {{ html()->hidden('id', $custom_form_field->id) }}
                {{ html()->hidden('form_id', $custom_form_field->form_id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Name', 'name') }}
                                        {{ html()->text('name', $custom_form_field->name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Type', 'type') }}
                                        {{ html()->text('type', $custom_form_field->type)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Variable name', 'variable_name') }}
                                        {{ html()->text('variable_name', $custom_form_field->variable_name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Sort order', 'sort_order') }}
                                        {{ html()->number('sort_order', $custom_form_field->sort_order)->class('form-control') }}
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
