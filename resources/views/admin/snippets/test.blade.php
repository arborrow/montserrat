@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Snippet tests</h1>
        <p>Use this page to test snippets by sending an email to your self with fake data.</p>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url'=>'admin/snippet/test', 'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        {!! Form::label('title', 'Title') !!}
                        {!! Form::select('title', $titles, $title, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::text('email', $email, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('language', 'Language') !!}
                        {!! Form::select('language', $languages, $language, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::submit('Run snippet test', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
