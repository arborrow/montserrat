@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create snippet</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url'=>'admin/snippet', 'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        {!! Form::label('title', 'Title') !!}
                        {!! Form::text('title', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('label', 'Label') !!}
                        {!! Form::text('label', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('locale', 'Language') !!}
                        {!! Form::select('locale', $locales, 'en_US', ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::label('snippet', 'Snippet') !!}
                        {!! Form::textarea('snippet', NULL, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::submit('Add snippet', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
