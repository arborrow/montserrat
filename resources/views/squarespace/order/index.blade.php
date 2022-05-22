@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">SquareSpace Orders (Unprocessed)</span>
                    </h1>
                    <span>{{ $orders->links() }}</span>

                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Orders (Unprocessed) ({{$orders->total()}})</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Retreat</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ URL('squarespace/order/' . $order->id) }} ">{{ $order->created_at }}</a>
                            </td>
                            <td>{{ ucwords(strtolower($order->name)) }}</td>
                            <td>{{ strtolower($order->email) }}</td>
                            <td>{{ $order->retreat_description }}  ({{ $order->retreat_dates }})</td>
                            <td>{{ $order->comments }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <hr />

                <div class="panel-heading">
                    <h1>
                        <span class="grey">SquareSpace Processed Orders</span>
                    </h1>
                    <span>{{ $processed_orders->links() }}</span>

                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Processed Orders ({{$processed_orders->total()}})</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
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
                            <td>{{ ucwords(strtolower($processed_order->name)) }}</td>
                            <td>{{ strtolower($processed_order->email) }}</td>
                            <td>{{ $processed_order->retreat_description }}  ({{ $processed_order->retreat_dates }})</td>
                            <td>{{ $processed_order->comments }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>


            </div>
        </div>
    </section>
@stop
