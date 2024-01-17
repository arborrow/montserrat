@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $inventory->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Squarespace Inventory</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('inventory.update', [$inventory->id]))->open() }}
                {{ html()->hidden('id', $inventory->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Name:', 'name') }}
                                        {{ html()->text('name', $inventory->name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Custom Form:', 'custom_form_id') }}
                                        {{ html()->select('custom_form_id', $custom_forms, $inventory->custom_form_id)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Variant options:', 'variant_options') }}
                                        {{ html()->number('variant_options', $inventory->variant_options)->class('form-control')->attribute('step', '1') }}
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
