@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create Squarespace Inventory</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'admin/squarespace/inventory/')->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Name', 'name') }}
                        {{ html()->text('name')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Custom Form:', 'custom_form_id') }}
                        {{ html()->select('custom_form_id', $custom_forms)->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Variant options:', 'variant_options') }}
                        {{ html()->number('variant_options', 0)->class('form-control')->attribute('step', '1') }}
                    </div>


                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add Squarespace Inventory')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
