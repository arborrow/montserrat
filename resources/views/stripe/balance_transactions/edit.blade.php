@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Process Balance Transaction ID #{{ $balance_transaction->id }}
        </h1>
    </div>
    <div class="col-lg-12">
        <a class="btn btn-light" data-toggle="collapse" href="#collapsedInstructions" role="button" aria-expanded="false" aria-controls="collapsedInstructions">
            Instructions
        </a>
    </div>
    <div class="collapse" id="collapsedInstructions">
        <div class="card card-body">
            <ol>
                @switch ($balance_transaction->transaction_type)
                @case ('Manual')
                    <li>Select the desired <strong><u>Donor</u></strong> from the Donor dropdown list and <u>click</u> on the <i>Retrieve Donor</i> button.
                    <li>If applicable, select the desired <strong><u>Retreat</u></strong> from the Retreat dropdown list.</li>
                    <li>If more than one category is associated with the balance transaction, allocate the donation appropriately.</li>
                    <li>Review the data and then <u>click</u> on the <i>Process Balance Transaction</i> button</li>
                    <li>The donation(s) and payment(s) associated with the Balance Transaction will be created.
                    @break
                @case ('Donation')
                    <li>Select the appropriate Squarespace Contribution</li>
                    <li>Click on the <i>Process Balance Transaction: Contribution</i> button</li>
                    @break
                @endswitch
            </ol>
        </div>
    </div>

    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['stripe.balance_transaction.update', $balance_transaction->id]]) !!}
        {!! Form::hidden('id', $balance_transaction->id) !!}
        {!! Form::hidden('payout_id', $balance_transaction->payout_id) !!}
        
        <hr>
        <div class="form-group">
            <div class="row">
                @switch ($balance_transaction->transaction_type)
                    @case ('Manual')
                        <div class="col-lg-4 col-md-6">
                            <h3>
                                {!! Form::label('contact_id', 'Donor: ' .$balance_transaction->name) !!}</h3>
                                {!! Form::select('contact_id', $matching_contacts, (isset($balance_transaction->contact_id)) ? $balance_transaction->contact_id : 0, ['class' => 'form-control']) !!}
                            </h3>
                            <hr />
                            <strong>Name: </strong>{{ $balance_transaction->name }}
                            <br /><strong>Email: </strong>{{ $balance_transaction->email }}
                            <br /><strong>Zip: </strong>{{ $balance_transaction->zip }}
                            <br /><strong>Credit Card Last 4: </strong>{{ $balance_transaction->cc_last_4 }}

                        </div>
                        <div class="col-lg-4 col-md-6">
                            <h3>
                                {!! Form::label('event_id', 'Retreat:') !!}
                            </h3>
                            {!! Form::select('event_id', $retreats, null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <h3>
                                Total Amount: ${{ number_format($balance_transaction->total_amount,2) }}
                            </h3>                    
                            @if (is_array($transaction_types))
                                @foreach ($transaction_types as $type)
                                    {!! Form::label($type, $type) !!}</h3>
                                    {!! Form::number($type, null, ['class' => 'form-control']) !!}
                                @endForeach
                            @else
                                {!! Form::label($transaction_types, $transaction_types) !!}</h3>
                                {!! Form::number($transaction_types, $balance_transaction->total_amount, ['class' => 'form-control']) !!}
                            @endIf
                            <hr />
                            <strong>Total Amount: </strong> ${{ number_format($balance_transaction->total_amount,2) }}
                            <br /><strong>Fee: </strong> ${{ number_format($balance_transaction->fee_amount,2) }}
                            <br /><strong>Net Amount: </strong> ${{ number_format($balance_transaction->net_amount,2) }}
                            <br /><strong>Note: </strong>{{ $balance_transaction->note }}
                            <br /><strong>Type: </strong>{{ $balance_transaction->type }}
                            
                        </div>
                        <div class='col-lg-4 col-md-6'>
                            <strong>Payout Date: </strong>{{ (isset($balance_transaction->payout_date)) ? $balance_transaction->payout_date->format('m-d-Y') : null }}
                            <br /><strong>Available Date: </strong>{{ (isset($balance_transaction->available_date)) ? $balance_transaction->available_date->format('m-d-Y') : null }}
                            <br /><strong>Reconciliation Date: </strong>{{ (isset($balance_transaction->reconcile_date)) ? $balance_transaction->reconcile_date->format('m-d-Y') : null }}
                        </div>
                    </div>
                    @break
                @case ('Donation')
                    <div class="col-lg-4 col-md-6">
                        <h3>
                            {!! Form::label('contribution_id', 'Contribution for: ' .$balance_transaction->name) . ' - $' . number_format($balance_transaction->total_amount,2) . ' - ' . $balance_transaction->payout_date->format('m-d-Y') !!}</h3>
                            {!! Form::select('contribution_id', $unprocessed_squarespace_contributions, null, ['class' => 'form-control']) !!}
                        </h3>
                    </div>
                    @break
                @endSwitch
            </div>  
        
            <div class="row text-center mt-3">
                <div class='col-lg-12'>
                    @if (!isset($balance_transaction->reconciled))
                        @switch ($balance_transaction->transaction_type)
                            @case ('Manual')
                                @if ($balance_transaction->contact_id > 0)
                                    {!! Form::submit('Process Balance Transaction',['class' => 'btn btn-dark']) !!}
                                @else
                                    {!! Form::submit('Retrieve Contact Info',['class' => 'btn btn-info']) !!}
                                @endif
                                @break
                            @case('Donation')
                                {!! Form::submit('Process Balance Transaction: Contribution',['class' => 'btn btn-dark']) !!}
                                @break
                        @endswitch
                    @else
                        <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'index']) }}">Balance Transaction #{{ $balance_transaction->id }} has already been processed</a>
                    @endIf
                </div>
            </div>
            <hr>            
            <div class="row">
                <div class='col-lg-6 col-md-8'>
                    <strong>Payout ID: </strong><a href="{{URL('stripe/payout/'.$balance_transaction->payout_id)}}"> {{$balance_transaction->payout_id}} </a>
                    <br /><strong>Balance Transaction ID: </strong><a href="{{URL('stripe/balance_transaction/'.$balance_transaction->balance_transaction_id)}}"> {{ $balance_transaction->balance_transaction_id }} </a>
                    <br /><strong>Charge ID: </strong><a href="{{URL('stripe/charge/'.$balance_transaction->charge_id)}}"> {{$balance_transaction->charge_id}}</a>
                    <br /><strong>Customer ID: </strong>{{$balance_transaction->customer_id}}
                </div>
            </div>
            
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
