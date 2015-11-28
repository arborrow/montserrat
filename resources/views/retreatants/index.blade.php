@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Retreatant Index</span> 
                    <span class="create"><a href={{ action('RetreatantsController@create') }}>{!! Html::image('img/create.png', 'Create a Retreatant',array('title'=>"Create Retreatant",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if ($retreatants->isEmpty())
                    <p>Sadly, there are no retreatants yet!</p>
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
                        @foreach($retreatants as $retreatant)
                        <tr>
                            <td><a href="retreatant/{{ $retreatant->id}}">{{ $retreatant->lastname }}</a></td>
                            <td>{{ $retreatant->firstname }}</td>
                            <td>{{ $retreatant->city }}</td>
                            <td>{{ $retreatant->homephone }}</td>
                            <td>{{ $retreatant->mobilephone }}</td>
                            <td>{{ $retreatant->email }}</td>
                            <td>{{ $retreatant->parish_id}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop