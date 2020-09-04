@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit: {!! $snippet->title !!}</h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <h2>Snippet</h2>
            </div>
            <div class="col-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['snippet.update', $snippet->id]]) !!}
                {!! Form::hidden('id', $snippet->id) !!}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('title', 'Title') !!}
                                        {!! Form::text('title', $snippet->title , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-3">
                                        {!! Form::label('label', 'Label') !!}
                                        {!! Form::text('label', $snippet->label , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-3">
                                        {!! Form::label('locale', 'Locale') !!}
                                        {!! Form::select('locale', $locales, $snippet->locale, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        {!! Form::label('snippet', 'Snippet') !!}
                                        {!! Form::textarea('snippet', $snippet->snippet, ['class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
