@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $export_list->label !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Export list</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('export_list.update', [$export_list->id]))->open() }}
                {{ html()->hidden('id', $export_list->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-lg-4">
                                      {{ html()->label('Title', 'title') }}
                                      {{ html()->text('title', $export_list->title)->class('form-control') }}
                                  </div>
                                  <div class="col-lg-4">
                                      {{ html()->label('Label', 'label') }}
                                      {{ html()->text('label', $export_list->label)->class('form-control') }}
                                  </div>
                                  <div class="col-lg-4">
                                      {{ html()->label('Type', 'type') }}
                                      {{ html()->select('type', $export_list_types, $export_list->type)->class('form-control') }}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-4">
                                      {{ html()->label('Starts: ', 'start_date') }}
                                      {{ html()->text('start_date', $export_list->start_date)->id('start_date')->class('form-control flatpickr-date-time bg-white') }}
                                  </div>
                                  <div class="col-lg-4">
                                      {{ html()->label('Ends: ', 'end_date') }}
                                      {{ html()->text('end_date', $export_list->end_date)->id('end_date')->class('form-control flatpickr-date-time bg-white') }}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-4">
                                      {{ html()->label('Last run: ', 'last_run_date') }}
                                      {{ html()->text('last_run_date', $export_list->last_run_date)->id('last_run_date')->class('form-control flatpickr-date-time bg-white') }}
                                  </div>
                                  <div class="col-lg-4">
                                      {{ html()->label('Next scheduled: ', 'next_scheduled_date') }}
                                      {{ html()->text('next_scheduled_date', $export_list->next_scheduled_date)->id('next_scheduled_date')->class('form-control flatpickr-date-time bg-white') }}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-3 col-md-4">
                                      {{ html()->label('Fields', 'fields') }}
                                      {{ html()->textarea('fields', $export_list->fields)->class('form-control') }}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-3 col-md-4">
                                      {{ html()->label('Filters', 'filters') }}
                                      {{ html()->textarea('filters', $export_list->filters)->class('form-control') }}
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
