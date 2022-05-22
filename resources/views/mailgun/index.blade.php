@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Index of Mailgun Stored Messages</span>
                        <span class="create">
                            <a href="{{ action([\App\Http\Controllers\MailgunController::class, 'get']) }}">
                               {!! Html::image('images/create.png', 'Add Group',array('title'=>"Add Group",'class' => 'btn btn-primary')) !!}
                            </a>

                        </span>
                        <p class="lead">{{$messages->total()}} records</p>

                    </h1>
                </div>
                @if ($messages->isEmpty())
                    <p>It is a brand new world, there are no stored messages!</p>
                @else
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
            </div>
        </div>
    </section>
@stop
