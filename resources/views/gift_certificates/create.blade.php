@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create Gift Certificate</h1>
    </div>

    <div class="col-lg-12">
        <a class="btn btn-light" data-toggle="collapse" href="#collapsedInstructions" role="button" aria-expanded="false" aria-controls="collapsedInstructions">
            Instructions
        </a>
    </div>
    <div class="collapse" id="collapsedInstructions">
        <div class="card card-body">
            <ol>
                <li>Type the first and last name of the person <u>purchasing</u> the gift certificate in the <strong><u>Name of Purchaser</u></strong> text box
                <li>Type the first and last name of the person <u>recievivg</u> the gift certificate in the <strong><u>Name of Recipient</u></strong> text box
                <li>Click on the <strong><u>Retrieve Purchasers and Recipients</u></strong> button
                <li>Select the desired <strong><u>Purchaser</u></strong> from the Purchaser dropdown list
                <li>Select the desired <strong><u>Recipient</u></strong> from the Recipient dropdown list
 
                <li>If the gift certificate is a purchase (funded) from the Squarespace website, enter the Squarespace Order # of the gift certificate purchase
                <li>If the gift certificate is unfunded (a donation from Montserrat), enter the next sequential number to be used as the gift certificate number 
                <li>If needed, adjust the scheduled, issued and expiration dates
                <li>If the gift certificate is funded (an order), enter the amount in the <strong><u>Funded amount</strong></u> field
                <li>If available, enter the Donation ID in the <strong><u>Donation ID</strong></u> field
                <li>Enter any descriptive notes the <strong><u>Notes</strong></u> field
                <li>When finished entering all the available, <strong><u>click</u></strong> on the <i>Add Gift Certificate</i> button.
                <li>The Gift Certificate will be added to the list of available gift certificates.
                    The gift certificat will be created and added as an attachment to the purchaser's record.
                    A touchpoint for the purchaser will be created.
            </ol>
        </div>
    </div>


    <div class="col-lg-12">
        {!! Form::open(['url'=>'gift_certificate', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group">
            <div class="border  border-secondary m-2 p-2">
                <h3 class="text-primary">Info</h3>
                <div class="row">

                    @if (!isset($purchasers))
                        <div class="col-lg-3">
                            {!! Form::label('purchaser_name', 'Name of Purchaser:') !!}
                            {!! Form::text('purchaser_name', NULL , ['class' => 'form-control']) !!}
                        </div>
                    @else
                        <div class="col-lg-3"> </div>
                    @endif

                    @if (!isset($recipients))
                        <div class="col-lg-3">
                            {!! Form::label('recipient_name', 'Name of Recipient:') !!}
                            {!! Form::text('recipient_name', NULL , ['class' => 'form-control']) !!}
                        </div>
                    @else
                        <div class="col-lg-3"> </div>
                    @endif
                    
                    @if (!isset($purchasers) || !isset($recipients))
                        <div class="col-lg-3">
                            <br>
                            {!! Form::submit('Retrieve Purchasers and Recipients', ['class'=>'text-wrap btn btn-md btn-outline-dark']) !!}
                        </div>
                    @endif
                </div>
                <div class="row">

                    <div class="col-lg-3">
                        @if (isset($purchasers))
                            {!! Form::label('purchaser_id', 'Purchaser:') !!}
                            {!! Form::select('purchaser_id', $purchasers, null, ['class' => 'form-control']) !!}
                            {!! Form::hidden('purchaser_name', str_replace(" (Add New Person)","", $purchasers[0])) !!}
                        @endif
                    </div>


                    <div class="col-lg-3">
                        @if (isset($recipients))
                            {!! Form::label('recipient_id', 'Recipient:') !!}
                            {!! Form::select('recipient_id', $recipients, null, ['class' => 'form-control']) !!}
                            {!! Form::hidden('recipient_name', str_replace(" (Add New Person)","", $recipients[0])) !!}
                        @endIf
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
            </div>
            
            <div class="border border-secondary m-2 p-2">
                <h3 class="text-primary">Dates</h3>
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
                        {!! Form::date('expiration_date', \Carbon\Carbon::now()->addYear()->addDay(), ['class'=>'form-control flatpickr-date-time', 'autocomplete'=> 'off']) !!}
                    </div>
                </div>
            </div>  

            <div class="border border-secondary m-2 p-2">
                <h3 class="text-primary">Funding</h3>
                <div class="row">
                    <div class="col-lg-3">
                        {!! Form::label('funded_amount', 'Funded amount:') !!}
                        {!! Form::number('funded_amount', 0, ['class' => 'form-control','step'=>'0.01']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('donation_id', 'Donation ID:') !!}
                        {!! Form::number('donation_id', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('participant_id', 'Participant ID:') !!}
                        {!! Form::number('participant_id', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="border border-secondary m-2 p-2">
                <h3 class="text-primary">Notes</h3>
                <div class="row">
                    <div class="col-lg-3">
                        {!! Form::label('notes', 'Notes:') !!}
                        {!! Form::textarea('notes', NULL, ['class' => 'form-control', 'rows' => 2]) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('retreat_type', 'Retreat type:') !!}
                        {!! Form::text('retreat_type', NULL , ['class' => 'form-control']) !!}
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-12">
                {!! Form::submit('Add Gift Certificate', ['class'=>'text-wrap btn btn-md btn-outline-dark']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
