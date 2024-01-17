@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $snippet->title !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Snippet</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('snippet.update', [$snippet->id]))->open() }}
                {{ html()->hidden('id', $snippet->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3">
                                        {{ html()->label('Title', 'title') }}
                                        {{ html()->text('title', $snippet->title)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3">
                                        {{ html()->label('Label', 'label') }}
                                        {{ html()->text('label', $snippet->label)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3">
                                        {{ html()->label('Locale', 'locale') }}
                                        {{ html()->select('locale', $locales, $snippet->locale)->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ html()->label('Snippet', 'snippet') }}
                                        {{ html()->textarea('snippet', $snippet->snippet)->class('form-control')->rows(3) }}
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
