@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Touch point Index</span> 
                    <span class="create"><a href={{ action('TouchpointsController@create') }}>{!! Html::image('img/create.png', 'Add Touchpoint',array('title'=>"Add Touchpoint",'class' => 'btn btn-primary')) !!}</a></span></h1>
                
                </div>
                @if ($touchpoints->isEmpty())
                    <p>It is a brand new world, there are no touch points!</p>
                @else
                <table class="table"><caption><h2>Touch points</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name of Contact</th>
                            <th>Contacted by</th>
                            <th>Type of contact</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($touchpoints as $touchpoint)
                        <tr>
                            <td><a href="touchpoint/{{ $touchpoint->id}}">{{ $touchpoint->touched_at }}</a></td>
                            <td><a href="person/{{ $touchpoint->person->id}}">{{ $touchpoint->person->lastname }}, {{ $touchpoint->person->firstname }}</a></td>
                            <td><a href="person/{{ $touchpoint->staff->id}}">{{ $touchpoint->staff->lastname }}, {{ $touchpoint->staff->firstname }}</a></td>
                            <td>{{ $touchpoint->type }}</td>
                            <td>{{ $touchpoint->notes }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop