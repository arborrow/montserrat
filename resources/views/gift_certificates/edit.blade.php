@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit Gift Certificate</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['gift_certificate.update', $gift_certificate->id],'enctype'=>'multipart/form-data']) !!}
        {!! Form::hidden('id', $gift_certificate->id) !!}

        <div class="form-group">

            <h3 class="text-primary">Gift certificate info</h3>
            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('purchaser_id', 'Purchaser ID:') !!}
                    {!! Form::number('purchaser_id', $gift_certificate->purchaser_id, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('recipient_id', 'Recipient ID:') !!}
                    {!! Form::number('recipient_id', $gift_certificate->recipient_id, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('squarespace_order_number', 'Squarespace Order #:') !!}
                    {!! Form::number('squarespace_order_number', $gift_certificate->squarespace_order_number, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('sequential_number', 'Sequential #:') !!}
                    {!! Form::number('sequential_number', $gift_certificate->sequential_number, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('participant_id', 'Participant ID:') !!}
                    {!! Form::number('participant_id', $gift_certificate->participant_id, ['class' => 'form-control']) !!}
                </div>
            </div>

            <h3 class="text-primary">Gift certificate dates</h3>
            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('purchase_date', 'Scheduled:') !!}
                    {!! Form::date('purchase_date', $gift_certificate->purchase_date, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>

                <div class="col-lg-3">
                    {!! Form::label('issue_date', 'Issued:') !!}
                    {!! Form::date('issue_date', $gift_certificate->issue_date, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('expiration_date', 'Expiration:') !!}
                    {!! Form::date('expiration_date', $gift_certificate->expiration_date, ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                </div>
            </div>

            <h3 class="text-primary">Notes</h3>
            <div class="row">
                <div class="col-lg-3">
                    {!! Form::label('funded_amount', 'Funded amount:') !!}
                    {!! Form::number('funded_amount', $gift_certificate->funded_amount, ['class' => 'form-control','step'=>'0.01']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('retreat_type', 'Retreat type:') !!}
                    {!! Form::text('retreat_type', $gift_certificate->retreat_type , ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3">
                    {!! Form::label('notes', 'Notes:') !!}
                    {!! Form::textarea('notes', $gift_certificate->notes, ['class' => 'form-control', 'rows' => 2]) !!}
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
@stop
