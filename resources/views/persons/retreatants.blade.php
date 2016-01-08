@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Retreatants Index</span> 
                    <span class="create"><a href={{ action('PersonsController@create') }}>{!! Html::image('img/create.png', 'Add Person',array('title'=>"Add Person",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="person"><a href={{ action('PersonsController@index') }}>{!! Html::image('img/person.png', 'Show Persons',array('title'=>"Show Persons",'class' => 'btn btn-primary')) !!}</a></span></h1>
                
                </div>
                @if ($persons->isEmpty())
                    <p>Currently, there are no retreatants</p>
                @else
                <table class="table"><caption><h2>Retreatants</h2></caption>
                    <thead>
                        <tr>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>City</th>
                            <th>Home phone</th>
                            <th>Cell phone</th>
                            <th>Email</th>
                            <th>Parish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($persons as $person)
                        <tr>
                            <td><a href="person/{{ $person->id}}">{{ $person->lastname }}</a></td>
                            <td>{{ $person->firstname }}</td>
                            <td>{{ $person->city }}</td>
                            <td>{{ $person->homephone }}</td>
                            <td>{{ $person->mobilephone }}</td>
                            <td>{{ $person->email }}</td>
                            <td>{{ $person->parish_id}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop