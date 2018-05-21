@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Index of Google Master Calendar Events</span>
                        <span class="create">
                            <a href="{{ action('RetreatController@calendar') }}">
                               {!! Html::image('img/create.png', 'Add Group',array('title'=>"Add Group",'class' => 'btn btn-primary')) !!}
                            </a>

                        </span>
                    </h1>
                </div>
                @if ($calendar_events->isEmpty())
                    <p>It is a brand new world, there are no stored messages!</p>
                @else
                <table class="table table-bordered table-striped"><caption><h2>Mailgun stored messages</h2></caption>
                    <thead>
                        <tr>
                            <th>Start</th>
                            <th>End</th>
                            <th>Summary</th>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Kind</th>
                            <th>Created</th>
                            <th>LastUpdated</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calendar_events as $event)
                        <tr>
                            <td>{{ $event->startDateTime }}</td>
                            <td>{{ $event->endDateTime }}  </td>
                            <td>{{ $event->summary }} </td>
                            <td><a href="{{$event->htmlLink}}">{{ $event->id }}</a></td>
                            <td>{!! $event->description !!}</td>
                            <td>{{ $event->kind }}</td>
                            <td>{{ $event->created }}</td>
                            <td>{{ $event->updated }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop