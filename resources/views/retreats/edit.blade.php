@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit: Event (#{{ $retreat->idnumber }})</h1>
    </div>
    <div class="col-12">
        {!! Form::open(['method' => 'PUT', 'files'=>'true','route' => ['retreat.update', $retreat->id]]) !!}
        {!! Form::hidden('id', $retreat->id) !!}
        <div class="row text-center">
            <div class="col-12">
                {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            {!! Form::label('idnumber', 'ID#:')  !!}
                            {!! Form::text('idnumber', $retreat->idnumber, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('start_date', 'Starts:') !!}
                            {!! Form::text('start_date', date('F j, Y g:i A', strtotime($retreat->start_date)), ['id' => 'start_date', 'class' => 'form-control form-control flatpickr-datetime']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('end_date', 'Ends:') !!}
                            {!! Form::text('end_date', date('F j, Y g:i A', strtotime($retreat->end_date)), ['id' => 'end_date', 'class' => 'form-control form-control flatpickr-datetime']) !!}
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            {!! Form::label('title', 'Title:') !!}
                            {!! Form::text('title', $retreat->title, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('directors','Director(s):')  !!}
                            {!! Form::select('directors[]', $options['directors'], $retreat->retreatmasters->pluck('contact.id'), ['id'=>'directors','class' => 'form-control select2','multiple' => 'multiple']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('ambassadors', 'Ambassador(s):') !!}
                            {!! Form::select('ambassadors[]', $options['ambassadors'], $retreat->ambassadors->pluck('contact.id'), ['id'=>'ambassadors','class' => 'form-control select2','multiple' => 'multiple']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            {!! Form::label('innkeepers', 'Innkeeper:') !!}
                            {!! Form::select('innkeepers[]', $options['innkeepers'], $retreat->innkeepers->pluck('contact.id'), ['id'=>'innkeepers','class' => 'form-control select2','multiple' => 'multiple']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('assistants', 'Assistant:') !!}
                            {!! Form::select('assistants[]', $options['assistants'], $retreat->assistants->pluck('contact.id'), ['id'=>'assistants','class' => 'form-control select2','multiple' => 'multiple']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                                {!! Form::label('event_type', 'Type: ') !!}
                                {!! Form::select('event_type', $event_types, $retreat->event_type_id, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            {!! Form::label('is_active', 'Cancelled?:')  !!}
                            {!! Form::select('is_active', $is_active, $retreat->is_active, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! Form::label('description', 'Description:') !!}
                            {!! Form::textarea('description', $retreat->description, ['class' => 'form-control', 'rows'=>'3']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-2">
                            {!! Form::label('contract', 'Contract (max 5M|pdf): ')  !!}
                            {!! Form::file('contract') !!}
                        </div>
                        <div class="col-12 mt-2">
                            {!! Form::label('schedule', 'Schedule (max 5M|pdf):')  !!}
                            {!! Form::file('schedule'); !!}
                        </div>
                        <div class="col-12 mt-2">
                            {!! Form::label('evaluations', 'Evaluations (max 10M|pdf):')  !!}
                            {!! Form::file('evaluations'); !!}
                        </div>
                        <div class="col-12 mt-2">
                            {!! Form::label('group_photo', 'Group photo (max 10M):')  !!}
                            {!! Form::file('group_photo'); !!}
                        </div>
                        @can('create-event-attachment')
                          <div class="col-6 mt-2">
                              {!! Form::label('event_attachment', 'Attachment (max 10M): ')  !!}
                              {!! Form::file('event_attachment',['class' => 'form-control']); !!}
                          </div>
                          <div class="col-6 mt-2">
                              {!! Form::label('event_attachment_description', 'Description: (max 200)')  !!}
                              {!! Form::text('event_attachment_description', NULL, ['class' => 'form-control']) !!}
                          </div>
                        @endCan
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-12">
                {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<div class="jumbotron text-left">
    <h1></h1>

    <div class="form-group">

    </div>
    <div class="clearfix"> </div>

    <div class="form-group">
        <span>

        </span>
    </div>
    <div class="form-group">
        <span>

        </span>
    </div>
    <div class="clearfix"> </div>

    <div class="form-group">

<!--        {!! Form::label('attending', 'Attending:') !!}
        {!! Form::text('attending', $retreat->attending) !!} -->
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">

    </div>
    <div class="clearfix"> </div>
    <div class="form-group">

    </div><div class="clearfix"> </div>

    <div class="form-group">

    </div><div class="clearfix"> </div>

    <div class="form-group">

    </div><div class="clearfix"> </div>

    <div class="form-group">

    </div><div class="clearfix"> </div>

    <div class="form-group">

    </div><div class="clearfix"> </div>
    <div class="form-group">

    </div><div class="clearfix"> </div>
    <div class="form-group">

@stop
