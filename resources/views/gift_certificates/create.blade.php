@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create Gift Certificate</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url'=>'gift_certificate', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group">

            <h3 class="text-primary">Gift certificate info</h3>
            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('purchaser_id', 'Purchaser ID:') !!}
                    {!! Form::number('purchaser_id', 0, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('recipient_id', 'Recipient ID:') !!}
                    {!! Form::number('recipient_id', 0, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('squarespace_order_number', 'Squarespace Order #:') !!}
                    {!! Form::number('squarespace_order_number', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('sequential_number', 'Sequential #:') !!}
                    {!! Form::number('sequential_number', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('participant_id', 'Participant ID:') !!}
                    {!! Form::number('participant_id', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <h3 class="text-primary">Gift certificate dates</h3>
            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('purchase_date', 'Scheduled:') !!}
                    {!! Form::date('purchase_date', now(), ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>

                <div class="col-lg-3">
                    {!! Form::label('issue_date', 'Issued:') !!}
                    {!! Form::date('issue_date', now(), ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('expiration_date', 'Expiration:') !!}
                    {!! Form::date('expiration_date', now(), ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>
            </div>

            <h3 class="text-primary">Notes</h3>
            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('funded_amount', 'Funded amount:') !!}
                    {!! Form::number('funded_amount', 0, ['class' => 'form-control','step'=>'0.01']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('retreat_type', 'Retreat type:') !!}
                    {!! Form::text('retreat_type', NULL , ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('notes', 'Notes:') !!}
                    {!! Form::textarea('notes', NULL, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>
            </div>

        </div>
        <div class="row text-center">
            <div class="col-lg-12">
                {!! Form::submit('Add Gift Certificate', ['class'=>'btn btn-outline-dark']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
