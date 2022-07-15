@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    @can('update-stripe-balance-transaction')
                        <h2>Stripe Balance Transaction #{{$balance_transaction->id}} details for 
                            <a href="{{url('stripe/balance_transaction/'.$balance_transaction->id.'/edit')}}">{{ $balance_transaction->balance_transaction_id }}</a>
                        </h2>
                    @else
                        <h2>
                            Stripe Balance Transaction #{{$balance_transaction->id}} details for {{ $balance_transaction->balance_transaction_id }}
                        </h2>
                    @endCan
                </span>
            </div>

            <div class='row'>
                <div class='col-md-4'>
                    <strong>Name: </strong>
                    @if (isset($balance_transaction->contact_id))
                        {{ $balance_transaction->name }} -
                        <a href="{!! $balance_transaction->contact->contact_url . '#donations' !!}">
                            {{ $balance_transaction->contact->full_name_with_city }}
                        </a> 
                    @else
                        {{ $balance_transaction->name }}
                    @endif
                    <br /><strong>Email: </strong>{{ $balance_transaction->email }}
                    <br /><strong>Zip: </strong>{{ $balance_transaction->zip }}
                    <br /><strong>Credit Card Last 4: </strong>{{ $balance_transaction->cc_last_4 }}
                    
                    <hr />
                    
                    <strong>Total Amount: </strong> ${{ number_format($balance_transaction->total_amount,2) }}
                    <br /><strong>Fee: </strong> ${{ number_format($balance_transaction->fee_amount,2) }}
                    <br /><strong>Net Amount: </strong> ${{ number_format($balance_transaction->net_amount,2) }}
                    <br /><strong>Description: </strong>{{$balance_transaction->description}}
                    <br /><strong>Note: </strong>{{ $balance_transaction->note }}
                    <br /><strong>Payment(s): </strong>
                    <ul>
                        @foreach ($balance_transaction->payments as $payment)
                            <li>
                                <a href="{{url('payment/'.$payment->payment_id)}}">{{$payment->payment_date->format('m-d-Y')}}</a> - {{$payment->donation->donation_description}} : ${{number_format($payment->payment_amount,2)}}
                            </li>
                        @endforeach
                    </ul>    
                    <hr />
                    <strong>Payout ID: </strong><a href="{{url('stripe/payout/'.$balance_transaction->payout_id)}}">{{$balance_transaction->payout_id}}</a>
                    <br /><strong>Charge ID: </strong><a href="{{url('stripe/charge/'.$balance_transaction->charge_id)}}">{{$balance_transaction->charge_id}}</a>
                    <br /><strong>Customer ID: </strong>{{$balance_transaction->customer_id}}
                    <br /><strong>Payout Date: </strong>{{ (isset($balance_transaction->payout_date)) ? $balance_transaction->payout_date->format('m-d-Y') : null }}
                    <br /><strong>Available Date: </strong>{{ (isset($balance_transaction->available_date)) ? $balance_transaction->available_date->format('m-d-Y') : null }}
                    <br /><strong>Reconciliation Date: </strong>{{ (isset($balance_transaction->reconcile_date)) ? $balance_transaction->reconcile_date->format('m-d-Y') : null }}
                    <hr />
                    
                </div>
            </div>

        </div>
    </div>
</section>
@stop
