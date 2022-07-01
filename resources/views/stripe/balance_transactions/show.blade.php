@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>Stripe Balance Transaction details for {{ $balance_transaction->balance_transaction_id }}</h2>
                </span>
            </div>

            <div class='row'>
                <div class='col-md-4'>

                    <strong>Payout ID: </strong>{{$balance_transaction->payout_id}}
                    <br /><strong>Customer ID: </strong>{{$balance_transaction->customer_id}}
                    <br /><strong>Charge ID: </strong>{{$balance_transaction->charge_id}}
                    <hr />
                    <strong>Total Amount: </strong> ${{ number_format($balance_transaction->total_amount,2) }}
                    <br /><strong>Fee: </strong> ${{ number_format($balance_transaction->fee_amount,2) }}
                    <br /><strong>Net Amount: </strong> ${{ number_format($balance_transaction->net_amount,2) }}
                    <hr />
                    <strong>Payout Date: </strong>{{ (isset($balance_transaction->payout_date)) ? $balance_transaction->payout_date->format('m-d-Y') : null }}
                    <br /><strong>Available Date: </strong>{{ (isset($balance_transaction->available_date)) ? $balance_transaction->available_date->format('m-d-Y') : null }}
                    <br /><strong>Reconciliation Date: </strong>{{ (isset($balance_transaction->reconciliation_date)) ? $balance_transaction->reconciliation_date->format('m-d-Y') : null }}
                    <hr />
                    <strong>Description: </strong>{{$balance_transaction->description}}
                    <br /><strong>Note: </strong>{{ $balance_transaction->note }}
                    <br /><strong>Type: </strong>{{ $balance_transaction->type }}
                    <hr />
                    <strong>Name: </strong>{{ $balance_transaction->name }}
                    <br /><strong>Email: </strong>{{ $balance_transaction->email }}
                    <br /><strong>Zip: </strong>{{ $balance_transaction->zip }}
                    <br /><strong>Phone: </strong>{{ $balance_transaction->phone }}
                    <br /><strong>Credit Card Last 4: </strong>{{ $balance_transaction->cc_last_4 }}
                </div>
            </div>

        </div>
    </div>
</section>
@stop
