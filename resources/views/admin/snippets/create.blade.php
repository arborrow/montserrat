@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create snippet</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('admin/snippet'))->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Title', 'title') }}
                        {{ html()->text('title')->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Label', 'label') }}
                        {{ html()->text('label')->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Language', 'locale') }}
                        {{ html()->select('locale', $locales, 'en_US')->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Snippet', 'snippet') }}
                        {{ html()->textarea('snippet')->class('form-control')->rows(3) }}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add snippet')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
