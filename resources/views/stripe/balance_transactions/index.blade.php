@extends('template')
@section('content')
    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Stripe Balance Transactions</span>
                    </h1>
                    
                </div>

                <span>{{ $processed_balance_transactions->links() }}</span>
                <table class="table table-bordered table-striped table-hover">
                    <caption>
                        <h2>
                            Unprocessed Stripe Balance Transactions ({{ $unprocessed_balance_transactions->total() }})
                        </h2>
                    </caption>
                    <thead>
                        <tr>
                            <th>Payout Date</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class='text-right'>Total</th>
                            <th class='text-right'>Fees</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($unprocessed_balance_transactions as $unprocessed_balance_transaction)
                        <tr>
                            <td>
                                <a href="{{ URL('stripe/balance_transaction/' . $unprocessed_balance_transaction->balance_transaction_id) }} ">{{ $unprocessed_balance_transaction->payout_date->format('M d, Y') }}</a>
                            </td>
                            <td>{{ $unprocessed_balance_transaction->name }}</td>
                            <td>{{ $unprocessed_balance_transaction->description }}</td>
                            <td class='text-right'>${{ number_format($unprocessed_balance_transaction->total_amount,2) }}</td>
                            <td class='text-right'>${{ number_format($unprocessed_balance_transaction->fee_amount,2) }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <span>{{ $processed_balance_transactions->links() }}</span>
                <table class="table table-bordered table-striped table-hover">
                    <caption>
                        <h2>
                            Processed Stripe Balance Transactions ({{ $processed_balance_transactions->total() }})
                        </h2>
                    </caption>
                    <thead>
                        <tr>
                            <th>Payout Date</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class='text-right'>Total</th>
                            <th class='text-right'>Fees</th>
                            <th class='text-right'>Payment ID</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($processed_balance_transactions as $processed_balance_transaction)
                        <tr>
                            <td>
                                <a href="{{ URL('stripe/balance_transaction/' . $processed_balance_transaction->balance_transaction_id) }} ">{{ $processed_balance_transaction->payout_date->format('M d, Y') }}</a>
                            </td>
                            <td>{{ $processed_balance_transaction->name }}</td>
                            <td>{{ $processed_balance_transaction->description }}</td>
                            <td class='text-right'>${{ number_format($processed_balance_transaction->total_amount,2) }}</td>
                            <td class='text-right'>${{ number_format($processed_balance_transaction->fee_amount,2) }}</td>
                            <td>
                                <a href="{{ URL('payments/' . $processed_balance_transaction->payment_id) }} ">
                                    {{ $processed_balance_transaction->payment_id }}
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

                
            </div>
        </div>
    </section>
@stop
