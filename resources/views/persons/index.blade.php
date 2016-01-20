@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Person Index</span> 
                    <span class="create"><a href={{ action('PersonsController@create') }}>{!! Html::image('img/create.png', 'Add Person',array('title'=>"Add Person",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="assistants"><a href={{ action('PersonsController@assistants') }}>{!! Html::image('img/assistant.png', 'Assistants',array('title'=>"Assistants",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="bishops"><a href={{ action('PersonsController@bishops') }}>{!! Html::image('img/bishop.png', 'Bishops',array('title'=>"Bishops",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="captains"><a href={{ action('PersonsController@captains') }}>{!! Html::image('img/captain.png', 'Captains',array('title'=>"Captains",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="directors"><a href={{ action('PersonsController@directors') }}>{!! Html::image('img/director.png', 'Directors',array('title'=>"Directors",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="donors"><a href={{ action('PersonsController@donors') }}>{!! Html::image('img/donor.png', 'Donors',array('title'=>"Donors",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="employees"><a href={{ action('PersonsController@employees') }}>{!! Html::image('img/employee.png', 'Employees',array('title'=>"Employees",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="innkeepers"><a href={{ action('PersonsController@innkeepers') }}>{!! Html::image('img/innkeeper.png', 'Innkeepers',array('title'=>"Innkeepers",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="pastors"><a href={{ action('PersonsController@pastors') }}>{!! Html::image('img/pastor.png', 'Pastors',array('title'=>"Pastors",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="volunteers"><a href={{ action('PersonsController@volunteers') }}>{!! Html::image('img/volunteer.png', 'Volunteers',array('title'=>"Volunteers",'class' => 'btn btn-primary')) !!}</a></span></h1>
                
                </div>
                @if ($persons->isEmpty())
                    <p>It is a brand new world, there are no persons!</p>
                @else
                <table class="table"><caption><h2>Persons</h2></caption>
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