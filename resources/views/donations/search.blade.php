@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Donations</strong></h1>
        </div>

        {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal', 'route' => ['donations.results']]) !!}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{!! Form::image('images/submit.png','btnSave',['class' => 'btn btn-outline-dark pull-right']) !!}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <h3 class="text-primary">Donation information</h3>
                    <div class="row">
                        <div class="col-lg-1">
                            {!! Form::label('donation_date_operator', 'Comp.')  !!}
                            {!! Form::select('donation_date_operator', config('polanco.operators'), '=', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('donation_date', 'Date')  !!}
                            {!! Form::date('donation_date', NULL, ['class'=>'form-control flatpickr-date']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('donation_description', 'Description')  !!}
                            {!! Form::select('donation_description', $descriptions, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('event_id', 'Retreat')  !!}
                            {!! Form::select('event_id', $retreats, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">
                            {!! Form::label('donation_amount_operator', 'Comp.')  !!}
                            {!! Form::select('donation_amount_operator', config('polanco.operators'), '=', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('donation_amount', 'Amount')  !!}
                            {!! Form::number('donation_amount', NULL, ['class' => 'form-control','step'=>'0.01']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('notes1', 'Primary contact for invoice')  !!}
                            {!! Form::text('notes1', NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {!! Form::label('notes', 'Notes')  !!}
                            {!! Form::text('notes', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-1">
                          {!! Form::label('start_date_operator', 'Comp.')  !!}
                          {!! Form::select('start_date_operator', config('polanco.operators'), '=', ['class' => 'form-control']) !!}
                      </div>
                        <div class="col-lg-3">
                            {!! Form::label('start_date', 'Start date')  !!}
                            {!! Form::date('start_date', NULL, ['class' => 'form-control flatpickr-date']) !!}
                        </div>
                        <div class="col-lg-1">
                            {!! Form::label('end_date_operator', 'Comp.')  !!}
                            {!! Form::select('end_date_operator', config('polanco.operators'), '=', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('end_date', 'End date')  !!}
                            {!! Form::date('end_date', NULL, ['class' => 'form-control flatpickr-date']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('stripe_invoice', 'Stripe Invoice #')  !!}
                            {!! Form::text('stripe_invoice', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">
                            {!! Form::label('donation_install_operator', 'Comp.')  !!}
                            {!! Form::select('donation_install_operator', config('polanco.operators'), '=', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('donation_install', 'Installment')  !!}
                            {!! Form::number('donation_install', NULL, ['class' => 'form-control','step'=>'0.01']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('terms', 'Terms')  !!}
                            {!! Form::text('terms', NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('donation_thank_you', 'Thank you letter')  !!}
                            {!! Form::select('donation_thank_you', ['' => 'N/A', 'Y' => 'Yes', 'N' => 'No'], NULL, ['class' => 'form-control']) !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@stop
