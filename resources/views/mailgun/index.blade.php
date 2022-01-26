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
                    </h1>
                </div>
                @if ($messages->isEmpty())
                    <p>It is a brand new world, there are no stored messages!</p>
                @else
                <table class="table table-bordered table-striped table-responsive"><caption><h2>Mailgun stored messages</h2></caption>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>To</th>
                            <th>From</th>
                            <th>Subject</th>
                            <th>ID</th>
                            <th>URL</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>{{ date('F d, Y h:i A',$message->timestamp) }}</td>
                            <td>{!! $message->contact['contact_link_full_name'] !!} <br /> {{ $message->to }} </td>
                            <td>{!! $message->staff['contact_link_full_name'] !!} <br /> {{ $message->from }} </td>
                            <td>{{ $message->message->headers->subject }}</td>
                            <td>{{ $message->id }}</td>
                            <td>{{ $message->storage->url }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop