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
                {{ html()->form('PUT', route('custom_form.update', [$custom_form->id]))->open() }}
                {{ html()->hidden('id', $custom_form->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Name', 'name') }}
                                        {{ html()->text('name', $custom_form->name)->class('form-control') }}
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
