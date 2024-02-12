@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Snippet tests</h1>
        <p>Use this page to test snippets by sending an email to your self with fake data.</p>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('admin/snippet/test'))->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Title', 'title') }}
                        {{ html()->select('title', $titles, $title)->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Email', 'email') }}
                        {{ html()->text('email', $email)->class('form-control')->attribute('rows', 3) }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Language', 'language') }}
                        {{ html()->select('language', $languages, $language)->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Run snippet test')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
