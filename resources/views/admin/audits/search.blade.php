@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Audit Logs</strong></h1>
        </div>

        {{ html()->form('GET', route('audits.results', ))->class('form-horizontal')->open() }}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{{ html()->input('image', 'btnSave')->class('btn btn-outline-dark pull-right')->attribute('src', asset('images/submit.png')) }}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <h3 class="text-primary">Audit information</h3>
                    <div class="row">
                        <div class="col-lg-1">
                            {{ html()->label('Comp.', 'created_at_operator') }}
                            {{ html()->select('created_at_operator', config('polanco.operators'), '=')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Created:', 'created_at') }}
                            {{ html()->date('created_at')->class('form-control flatpickr-date-time') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('User', 'user_id') }}
                            {{ html()->select('user_id', $users)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Model:', 'auditable_type') }}
                            {{ html()->select('auditable_type', $models)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('ID#:', 'auditable_id') }}
                            {{ html()->number('auditable_id')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Action:', 'event') }}
                            {{ html()->select('event', $actions)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Old value:', 'old_values') }}
                            {{ html()->text('old_values')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('New value:', 'new_values') }}
                            {{ html()->text('new_values')->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('URL:', 'url') }}
                            {{ html()->text('url')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Tags:', 'tags') }}
                            {{ html()->text('tags')->class('form-control') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
</div>

@stop
