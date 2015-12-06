@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Diocese Index</span> 
                    <span class="create"><a href={{ action('DiocesesController@create') }}>{!! Html::image('img/create.png', 'Create a Diocese',array('title'=>"Create Diocese",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if ($dioceses->isEmpty())
                    <p>No Dioceses are currently in the database.</p>
                @else
                <table class="table"><caption><h2>Parishes</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th> 
                            <th>Bishop</th> 
                            <th>Address</th> 
                            <th>Phone</th> 
                            <th>Email</th> 
                            <th>Webpage</th> 
                       </tr>
                    </thead>
                    <tbody>
                        @foreach($dioceses as $diocese)
                        <tr>
                            <td><a href="diocese/{{$diocese->id}}">{{ $diocese->name }}</a></td>
                            <td>{{ $diocese->bishop_id }}</td>
                            <td>{{ $diocese->address1 }}</td>
                            <td>{{ $diocese->phone }}</td>
                            <td><a href="mailto:{{ $diocese->email }}">{{ $diocese->email }}</a></td>
                            <td><a href="{{ $diocese->webpage }}" target="_blank">{{ $diocese->webpage }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop