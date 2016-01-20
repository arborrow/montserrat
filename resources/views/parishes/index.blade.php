@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Parish Index</span> 
                    <span class="create"><a href={{ action('ParishesController@create') }}>{!! Html::image('img/create.png', 'Create a Parish',array('title'=>"Create Parish",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if ($parishes->isEmpty())
                    <p>No parishes are currently in the database.</p>
                @else
                <table class="table"><caption><h2>Parishes</h2></caption>
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
                            <td>{{ $parish->pastor_id }}</td>
                            <td>{{ $parish->address1 }}</td>
                            <td>{{ $parish->phone }}</td>
                            <td>{{ $parish->email }}</td>
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