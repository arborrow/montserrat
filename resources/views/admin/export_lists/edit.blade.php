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
                {!! Form::open(['method' => 'PUT', 'route' => ['export_list.update', $export_list->id]]) !!}
                {!! Form::hidden('id', $export_list->id) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-lg-4">
                                      {!! Form::label('title', 'Title') !!}
                                      {!! Form::text('title', $export_list->title , ['class' => 'form-control']) !!}
                                  </div>
                                  <div class="col-lg-4">
                                      {!! Form::label('label', 'Label') !!}
                                      {!! Form::text('label', $export_list->label , ['class' => 'form-control']) !!}
                                  </div>
                                  <div class="col-lg-4">
                                      {!! Form::label('type', 'Type') !!}
                                      {!! Form::select('type', $export_list_types, $export_list->type, ['class' => 'form-control']) !!}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-4">
                                      {!! Form::label('start_date', 'Starts: ') !!}
                                      {!! Form::text('start_date', $export_list->start_date, ['id' => 'start_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                                  </div>
                                  <div class="col-lg-4">
                                      {!! Form::label('end_date', 'Ends: ') !!}
                                      {!! Form::text('end_date', $export_list->end_date, ['id' => 'end_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-4">
                                      {!! Form::label('last_run_date', 'Last run: ') !!}
                                      {!! Form::text('last_run_date', $export_list->last_run_date, ['id' => 'last_run_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                                  </div>
                                  <div class="col-lg-4">
                                      {!! Form::label('next_scheduled_date', 'Next scheduled: ') !!}
                                      {!! Form::text('next_scheduled_date', $export_list->next_scheduled_date, ['id' => 'next_scheduled_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-12 col-md-4">
                                      {!! Form::label('fields', 'Fields') !!}
                                      {!! Form::textarea('fields', $export_list->fields , ['class' => 'form-control']) !!}
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-12 col-md-4">
                                      {!! Form::label('filters', 'Filters') !!}
                                      {!! Form::textarea('filters', $export_list->filters , ['class' => 'form-control']) !!}
                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
