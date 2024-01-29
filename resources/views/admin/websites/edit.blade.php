@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $website->url !!}</h1>
    </div>
    <div class="col-lg-12">
        <h3>Website</h3>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('website.update', [$website->id]))->open() }}
        {{ html()->hidden('id', $website->id) }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('URL', 'url') }}
                    {{ html()->text('url', $website->url)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Type', 'website_type') }}
                    {{ html()->select('website_type', config('polanco.website_types'), $website->website_type)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ html()->label('Description', 'description') }}
                    {{ html()->textarea('description', $website->description)->class('form-control')->rows(3) }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Asset ID', 'asset_id') }}
                    {{ html()->text('asset_id', $website->asset_id)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Contact ID', 'contact_id') }}
                    {{ html()->text('contact_id', $website->contact_id)->class('form-control') }}
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
        </div>
    </div>
</div>
{{ html()->form()->close() }}
@stop
