@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create website (URL)</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'admin/website')->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('URL', 'url') }}
                        {{ html()->text('url')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Type', 'website_type') }}
                        {{ html()->select('website_type', config('polanco.website_types'))->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Description', 'description') }}
                        {{ html()->textarea('description')->class('form-control')->rows(3) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Asset ID', 'asset_id') }}
                        {{ html()->text('asset_id')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Contact ID', 'contact_id') }}
                        {{ html()->text('contact_id')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add website (URL)')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
