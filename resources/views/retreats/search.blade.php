@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Events</strong></h1>
        </div>

        {{ html()->form('GET', route('retreats.results', ))->class('form-horizontal')->open() }}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{{ html()->input('image', 'btnSave')->class('btn btn-outline-dark pull-right')->attribute('src', asset('images/submit.png')) }}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ html()->label('Begin Date:', 'begin_date')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('begin_date')->class('form-control flatpickr-date') }}
                    </div>

                    {{ html()->label('End Date:', 'end_date')->class('control-label col-sm-3') }}
                    <div class="col-sm-8">
                        {{ html()->text('end_date')->class('form-control flatpickr-date') }}
                    </div>

                    <div class="form-group">
                        {{ html()->label('Title:', 'title')->class('control-label col-sm-3') }}
                        <div class="col-sm-8">
                            {{ html()->text('title')->class('form-control') }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ html()->label('ID number:', 'idnumber')->class('control-label col-sm-3') }}
                        <div class="col-sm-8">
                            {{ html()->text('idnumber')->class('form-control') }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ html()->label('Event type:', 'event_type_id')->class('control-label col-sm-3') }}
                        <div class="col-sm-8">
                        {{ html()->select('event_type_id', $event_types)->class('form-control') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
</div>


@stop
