@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">{{$role['name']}} Index</span> 
                    <span class="create"><a href={{ action('PersonsController@create') }}>{!! Html::image('img/create.png', 'Add Person',array('title'=>"Add Person",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="person"><a href={{ action('PersonsController@index') }}>{!! Html::image('img/person.png', 'Show Persons',array('title'=>"Show Persons",'class' => 'btn btn-primary')) !!}</a></span></h1>
                
                </div>
                @if ($persons->isEmpty())
                    <p>Currently, there are no {{$role['name']}}</p>
                @else
                <table class="table"><caption><h2>{{$role['name']}}</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address (City)</th>
                            <th>Home phone</th>
                            <th>Cell phone</th>
                            <th>Email</th>
                            <th>Parish (Diocese)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($persons as $person)
                        <tr>
                            <td><a href="person/{{ $person->id}}">{{ $person->lastname }}, {{ $person->firstname }}</a></td>
                            <td>
                                {!!$address->google_map!!} 
                            </td>
                            <td>{{ $person->homephone }}</td>
                            <td>{{ $person->mobilephone }}</td>
                            <td><a href="mailto:{{$person->email}}">{{ $person->email }}</a></td>
                            <td>
                                @if (!isset($person->parish))
                                    N/A
                                @else
                                <a href="parish/{{$person->parish->id}}">{{ $person->parish->name }}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop