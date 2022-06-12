@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Index of Mailgun Messages</span>
                            <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\MailgunController::class, 'get']) }}">Get Messages</a>
                            <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\MailgunController::class, 'process']) }}">Process Messages</a>
                            <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'index']) }}">Squarespace Orders</a>
                            <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\SquarespaceContributionController::class, 'index']) }}">Squarespace Contributions</a>
                        </span>

                    </h1>
                </div>
                @if ($messages->isEmpty())
                    <p>There are no unprocessed messages.</p>
                @else
                <p class="lead">{{$messages->total()}} unprocessed messages</p>
                <table class="table table-bordered table-striped table-responsive"><caption><h2>Mailgun stored messages</h2></caption>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Recipient</th>
                            <th>Processed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td><a href="{{ url('mailgun/'.$message->id) }}">{{ $message->mailgun_timestamp }}</a></td>
                            <td>{!! optional($message->contact_from)->contact_link_full_name !!} <br /> {{ $message->from }} </td>
                            <td>{!! optional($message->contact_to)->contact_link_full_name !!} <br /> {{ $message->to }} </td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->recipients }}</td>
                            <td>{{ $message->is_processed ? 'Yes':'No' }}</td>
                        </tr>
                        @endforeach
                        {{ $messages->links() }}
                    </tbody>
                </table>
                @endif

                <hr />

                @if ($messages_processed->isEmpty())
                    <p>There are no processed messages.</p>
                @else
                <p class="lead">{{$messages_processed->total()}} processed messages</p>

                <table class="table table-bordered table-striped table-responsive"><caption><h2>Mailgun stored messages</h2></caption>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Recipient</th>
                            <th>Processed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages_processed as $message)
                        <tr>
                            <td><a href="{{ url('mailgun/'.$message->id) }}">{{ $message->mailgun_timestamp }}</a></td>
                            <td>{!! optional($message->contact_from)->contact_link_full_name !!} <br /> {{ $message->from }} </td>
                            <td>{!! optional($message->contact_to)->contact_link_full_name !!} <br /> {{ $message->to }} </td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->recipients }}</td>
                            <td>{{ $message->is_processed ? 'Yes':'No' }}</td>
                        </tr>
                        @endforeach
                        {{ $messages_processed->links() }}
                    </tbody>
                </table>
                @endif

            </div>
        </div>
    </section>
@stop
