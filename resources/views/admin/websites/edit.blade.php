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
        {!! Form::open(['method' => 'PUT', 'route' => ['website.update', $website->id]]) !!}
        {!! Form::hidden('id', $website->id) !!}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {!! Form::label('url', 'URL')  !!}
                    {!! Form::text('url', $website->url , ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3 col-md-4">
                    {!! Form::label('website_type', 'Type') !!}
                    {!! Form::select('website_type', config('polanco.website_types'), $website->website_type, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::label('description', 'Description') !!}
                    {!! Form::textarea('description', $website->description, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {!! Form::label('asset_id', 'Asset ID') !!}
                    {!! Form::text('asset_id', $website->asset_id , ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3 col-md-4">
                    {!! Form::label('contact_id', 'Contact ID') !!}
                    {!! Form::text('contact_id', $website->contact_id, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop
