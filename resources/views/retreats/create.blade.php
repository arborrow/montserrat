@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>Create Retreat</h2>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('retreat'))->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('ID#:', 'idnumber') }}
                        {{ html()->text('idnumber')->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Title: ', 'title') }}
                        {{ html()->text('title')->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Type:', 'event_type') }}
                        {{ html()->select('event_type', $event_types, config('polanco.event_type.ignatian'))->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Starts: ', 'start_date') }}
                        {{ html()->text('start_date')->id('start_date')->class('form-control flatpickr-date-time bg-white') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Ends: ', 'end_date') }}
                        {{ html()->text('end_date')->id('end_date')->class('form-control flatpickr-date-time bg-white') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Canceled?:', 'is_active') }}
                        {{ html()->select('is_active', $is_active, 1)->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                            {{ html()->label('Maximum participants', 'max_participants') }}
                            {{ html()->text('max_participants', 60)->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        {{ html()->label('Description:', 'description') }}
                        {{ html()->textarea('description')->class('form-control')->rows('3') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Director(s):', 'directors') }}
                        {{ html()->multiselect('directors[]', $d, 0)->id('directors')->class('form-control select2') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Innkeeper(s):', 'innkeeper_ids') }}
                        {{ html()->multiselect('innkeepers[]', $i, 0)->id('innkeepers')->class('form-control select2') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Assistant(s):', 'assistant_ids') }}
                        {{ html()->multiselect('assistants[]', $a, 0)->id('assistants')->class('form-control select2') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Ambassador(s):', 'ambassadors') }}
                        {{ html()->multiselect('ambassadors[]', $c, 0)->id('ambassadors')->class('form-control select2') }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mt-5">
                    {{ html()->submit('Add Retreat')->class('btn btn-light') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
