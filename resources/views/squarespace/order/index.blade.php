@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Squarespace Orders (Unprocessed)</span>
                    </h1>
                    <span>{{ $unprocessed_orders->links() }}</span>

                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Orders (Unprocessed) ({{$unprocessed_orders->total()}})</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Retreat</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($unprocessed_orders as $order)
                        <tr>
                            <td>
                                <a href="{{ URL('squarespace/order/' . $order->id .'/edit') }} ">{{ $order->created_at }}</a>
                            </td>
                            <td>{{ $order->order_number }}
                            <td>{{ ucwords(strtolower($order->name)) }}</td>
                            <td>{{ strtolower($order->email) }}</td>
                            <td>
                                @if ($order->is_gift_certificate)
                                    {{ $order->retreat_category }}
                                @else
                                    {{ $order->retreat_description }}  ({{ $order->retreat_dates }})
                                @endIf
                            </td>
                            <td>{{ $order->comments }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <hr />

                <div class="panel-heading">
                    <h1>
                        <span class="grey">Squarespace Processed Orders</span>
                    </h1>
                    <span>{{ $processed_orders->links() }}</span>

                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Processed Orders ({{$processed_orders->total()}})</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Retreat</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($processed_orders as $processed_order)
                        <tr>
                            <td>
                                <a href="{{ URL('squarespace/order/' . $processed_order->id) }} ">{{ $processed_order->created_at }}</a>
                            </td>
                            <td>{{ $processed_order->order_number }}
                            <td>{{ ucwords(strtolower($processed_order->name)) }}</td>
                            <td>{{ strtolower($processed_order->email) }}</td>                            
                            <td>
                                @if ($processed_order->is_gift_certificate)
                                    {{ $processed_order->retreat_category }}
                                @else
                                    {{ $processed_order->retreat_description }}  ({{ $processed_order->retreat_dates }})
                                @endIf
                            </td>
                            <td>{{ $processed_order->comments }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>


            </div>
        </div>
    </section>
@stop
