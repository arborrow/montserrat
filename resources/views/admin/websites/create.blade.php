@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create website (URL)</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url'=>'admin/website', 'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('url', 'URL')  !!}
                        {!! Form::text('url', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('website_type', 'Type') !!}
                        {!! Form::select('website_type', config('polanco.website_types'), NULL, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::label('description', 'Description') !!}
                        {!! Form::textarea('description', NULL, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('asset_id', 'Asset ID') !!}
                        {!! Form::text('asset_id', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('contact_id', 'Contact ID') !!}
                        {!! Form::text('contact_id', NULL , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::submit('Add website (URL)', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
