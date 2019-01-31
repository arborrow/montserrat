@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Index of Mailgun Processed Messages</span>
                        <span class="create">
                            <a href="{{ action('MailgunController@get') }}">
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
                            <th>Body</th>
                            <th>ID</th>
                            <th>URL</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                        <tr>
                            <td>{{ $message->mailgun_timestamp }}</td>
                            <td>{{ $message->to }} </td>
                            <td>{{ $message->from }} </td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->body }}</td>
                            <td>{{ $message->mailgun_id }}</td>
                            <td>{{ $message->storage_url }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop