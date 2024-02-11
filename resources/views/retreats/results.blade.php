@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">{{$events->total()}} results found</span>
                    <span class="search"><a href={{ action([\App\Http\Controllers\RetreatController::class, 'search']) }}>{{ html()->img(asset('images/search.png'), 'New search')->attribute('title', "New search")->class('btn btn-link') }}</a></span></h1>
                </div>
                @if ($events->isEmpty())
                    <p>Oops, no known events with the given search criteria</p>
                @else
                <table class="table table-striped table-bordered table-hover"><caption><h2>Events</h2></caption>
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Title</th>
                            <th>Starts - Ends</th>
                            <th># Attending</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>
                                <a href="{{url('retreat/'.$event->id)}}">{{ $event->idnumber}}</a>
                            </td>
                            <td>{{$event->title}}</td>
                            <td>
                                {{ date('M j, Y', strtotime($event->start_date)) }} - {{ date('M j, Y', strtotime($event->end_date)) }}
                            </td>
                            <td>
                                <a href="{{url('retreat/'.$event->id.'#registrations')}}">{{ $event->participant_count}}</a>
                            </td>
                        </tr>
                        @endforeach
                    {{ $events->links() }}
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
