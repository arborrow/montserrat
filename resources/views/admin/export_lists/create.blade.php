@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create export list</h1>
    </div>

    <div class="col-lg-12">
        {{ html()->form('POST', 'admin/export_list')->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('Title', 'title') }}
                        {{ html()->text('title')->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Label', 'label') }}
                        {{ html()->text('label')->class('form-control') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Type', 'type') }}
                        {{ html()->select('type', $export_list_types)->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('Starts: ', 'start_date') }}
                        {{ html()->text('start_date')->id('start_date')->class('form-control flatpickr-date-time bg-white') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Ends: ', 'end_date') }}
                        {{ html()->text('end_date')->id('end_date')->class('form-control flatpickr-date-time bg-white') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ html()->label('Last run: ', 'last_run_date') }}
                        {{ html()->text('last_run_date')->id('last_run_date')->class('form-control flatpickr-date-time bg-white') }}
                    </div>
                    <div class="col-lg-4">
                        {{ html()->label('Next scheduled: ', 'next_scheduled_date') }}
                        {{ html()->text('next_scheduled_date')->id('next_scheduled_date')->class('form-control flatpickr-date-time bg-white') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Fields', 'fields') }}
                        {{ html()->textarea('fields')->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Filters', 'filters') }}
                        {{ html()->textarea('filters')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add export list')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
