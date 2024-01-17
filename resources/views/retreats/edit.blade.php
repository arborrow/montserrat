@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: Event (#{{ $retreat->idnumber }})</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('retreat.update', [$retreat->id]))->acceptsFiles()->open() }}
        {{ html()->hidden('id', $retreat->id) }}
        <div class="row text-center">
            <div class="col-lg-12">
                {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <div class="row mt-3">
                        <div class="col-lg-3">
                            {{ html()->label('ID#:', 'idnumber') }}
                            {{ html()->text('idnumber', $retreat->idnumber)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Title:', 'title') }}
                            {{ html()->text('title', $retreat->title)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                                {{ html()->label('Type: ', 'event_type') }}
                                {{ html()->select('event_type', $event_types, $retreat->event_type_id)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Starts:', 'start_date') }}
                            {{ html()->datetime('start_date', $retreat->start_date)->class('form-control flatpickr-date-time')->id('start_date') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Ends:', 'end_date') }}
                            {{ html()->datetime('end_date', $retreat->end_date)->class('form-control flatpickr-date-time')->id('end_date') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Canceled?:', 'is_active') }}
                            {{ html()->select('is_active', $is_active, $retreat->is_active)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Maximum participants', 'max_participants') }}
                            {{ html()->text('max_participants', $retreat->max_participants)->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Google Calendar ID:', 'calendar_id') }}
                            {{ html()->text('calendar_id', $retreat->calendar_id)->class('form-control')->isReadonly() }}
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ html()->label('Director(s):', 'directors') }}
                            {{ html()->multiselect('directors[]', $options['directors'], $retreat->retreatmasters->pluck('contact.id'))->id('directors')->class('form-control select2') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Innkeeper:', 'innkeepers') }}
                            {{ html()->multiselect('innkeepers[]', $options['innkeepers'], $retreat->innkeepers->pluck('contact.id'))->id('innkeepers')->class('form-control select2') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Assistant:', 'assistants') }}
                            {{ html()->multiselect('assistants[]', $options['assistants'], $retreat->assistants->pluck('contact.id'))->id('assistants')->class('form-control select2') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Ambassador(s):', 'ambassadors') }}
                            {{ html()->multiselect('ambassadors[]', $options['ambassadors'], $retreat->ambassadors->pluck('contact.id'))->id('ambassadors')->class('form-control select2') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ html()->label('Description:', 'description') }}
                            {{ html()->textarea('description', $retreat->description)->class('form-control')->rows('3') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 mt-2">
                            {{ html()->label('Contract (max 5M|pdf): ', 'contract') }}
                            {{ html()->file('contract')->class('form-control') }}
                        </div>
                        <div class="col-lg-3 mt-2">
                            {{ html()->label('Schedule (max 5M|pdf):', 'schedule') }}
                            {{ html()->file('schedule')->class('form-control') }}
                        </div>
                        <div class="col-lg-3 mt-2">
                            {{ html()->label('Evaluations (max 10M|pdf):', 'evaluations') }}
                            {{ html()->file('evaluations')->class('form-control') }}
                        </div>
                        <div class="col-lg-3 mt-2">
                            {{ html()->label('Group photo (max 10M):', 'group_photo') }}
                            {{ html()->file('group_photo')->class('form-control') }}
                        </div>
                      </div>
                      <div class="row">
                        @can('create-event-attachment')
                          <div class="col-lg-3 mt-2">
                              {{ html()->label('Attachment (max 10M): ', 'event_attachment') }}
                              {{ html()->file('event_attachment')->class('form-control') }}
                          </div>
                          <div class="col-lg-3 mt-2">
                              {{ html()->label('Description: (max 200)', 'event_attachment_description') }}
                              {{ html()->text('event_attachment_description')->class('form-control') }}
                          </div>
                        @endCan
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12">
                {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>

@stop
