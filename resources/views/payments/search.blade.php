@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Payments</strong></h1>
        </div>

        {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal', 'route' => ['payments.results']]) !!}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{!! Form::image('images/submit.png','btnSave',['class' => 'btn btn-outline-dark pull-right']) !!}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <h3 class="text-primary">Payment information</h3>
                    <div class="row">
                        <div class="col-1">
                            {!! Form::label('payment_date_operator', 'Comp.')  !!}
                            {!! Form::select('payment_date_operator', config('polanco.operators'), '=', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('payment_date', 'Date')  !!}
                            {!! Form::date('payment_date', NULL, ['class'=>'form-control flatpickr-date']) !!}
                        </div>
                        <div class="col-1">
                            {!! Form::label('payment_amount_operator', 'Comp.')  !!}
                            {!! Form::select('payment_amount_operator', config('polanco.operators'), '=', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-3">
                            {!! Form::label('payment_amount', 'Amount')  !!}
                            {!! Form::number('payment_amount', NULL, ['class' => 'form-control','step'=>'0.01']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('payment_description', 'Payment method')  !!}
                            {!! Form::select('payment_description', $payment_methods, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('donation_description', 'Donation description')  !!}
                            {!! Form::select('donation_description', $descriptions, NULL, ['class' => 'form-control']) !!}
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-4">
                            {!! Form::label('note', 'Notes')  !!}
                            {!! Form::text('note', NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('cknumber', 'Check #')  !!}
                            {!! Form::number('cknumber', NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-4">
                            {!! Form::label('ccnumber', 'Credit Card #')  !!}
                            {!! Form::number('ccnumber', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@stop
