@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Diocese of Tyler Parish Index</span> 
                    <span class="create"><a href={{ action('ParishesController@create') }}>{!! Html::image('img/create.png', 'Create a Parish',array('title'=>"Create Parish",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if ($parishes->isEmpty())
                    <p>No Diocese of Tyler parishes are currently in the database.</p>
                @else
                <table class="table"><caption><h2>Diocese of Tyler Parishes</h2></caption>
                    <thead>
                        <tr>
                            <th>Diocese</th>
                            <th>Name</th> 
                            <th>Pastor</th> 
                            <th>Address</th> 
                            <th>Phone</th> 
                            <th>Email</th> 
                            <th>Webpage</th> 
                       </tr>
                    </thead>
                    <tbody>
                        @foreach($parishes as $parish)
                        <tr>
                            <td><a href="diocese/{{$parish->diocese_id}}">{{ $parish->diocese->name }}</a></td>
                            <td><a href="parish/{{$parish->id}}">{{ $parish->name }}</a></td>
                            <td><a href="person/{{$parish->pastor_id}}">{{ $parish->pastor->title or ''}} {{ $parish->pastor->firstname or ''}} {{ $parish->pastor->lastname or 'No pastor assigned'}}</a></td>
                            <td><a href="http://maps.google.com/?q={{$parish->address1}} {{ $parish->address2}} {{ $parish->city}} {{ $parish->state}} {{ $parish->zip}}" target="_blank">{{ $parish->address1}}</a></td>
                            <td>{{ $parish->phone }}</td>
                            <td><a href="mailto:{{ $parish->email }}">{{ $parish->email }}</a></td>
                            <td><a href="{{ $parish->webpage }}" target="_blank">{{ $parish->webpage }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop