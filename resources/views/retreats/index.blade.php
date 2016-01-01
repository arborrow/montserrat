@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Retreat Index</span> 
                    <span class="create"><a href={{ action('RetreatsController@create') }}>{!! Html::image('img/create.png', 'Create a Retreat',array('title'=>"Create Retreat",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if ($retreats->isEmpty())
                    <p> Currently, there are no current or upcoming retreats!</p>
                @else
                <table class="table"><caption><h2>Current and upcoming retreats</h2></caption>
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Title</th>
                            <th>Starts - Ends</th>
                            <th>Director</th>
                            <th>Innkeeper</th>
                            <th>Assistant</th>
                            <th># Attending</th>
                            <!--<th>Silent</th>
                            <th>Edit</th>
                            <th>Delete</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($retreats as $retreat)
                        <tr>
                            <td><a href="retreat/{{ $retreat->id}}">{{ $retreat->idnumber}}</a></td>
                            <td>{{ $retreat->title }}</td>
                            <td>{{ date('F d, Y', strtotime($retreat->start)) }} - {{ date('F d, Y', strtotime($retreat->end)) }}</td>
                            <td>{{ $retreat->directorname }}</td>
                            <td>{{ $retreat->innkeepername }}</td>
                            <td>{{ $retreat->assistantname }}</td>
                            <td>{{ $retreat->attending}}</td>
                            <!--<td>{{ $retreat->silent ? 'Yes' : 'No'}}</td>
                            <td><a href="{{ action('RetreatsController@edit', $retreat->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></td>
<td>{!! Form::open(['method' => 'DELETE', 'route' => ['retreat.destroy', $retreat->id]]) !!}
 {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
{!! Form::close() !!}
</td>-->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
<hr>
                @if ($oldretreats->isEmpty())
                    <p> Currently, there are no previous retreats!</p>
                @else
                <table class="table"><caption><h2>Previous retreats</h2></caption>
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Title</th>
                            <th>Starts - Ends</th>
                            <th>Director</th>
                            <th>Innkeeper</th>
                            <th>Assistant</th>
                            <th># Attending</th>
                            <!--<th>Silent</th>
                            <th>Edit</th>
                            <th>Delete</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($oldretreats as $oldretreat)
                        <tr>
                            <td><a href="retreat/{{ $oldretreat->id}}">{{ $oldretreat->idnumber}}</a></td>
                            <td>{{ $oldretreat->title }}</td>
                            <td>{{ date('F d, Y', strtotime($oldretreat->start)) }} - {{ date('F d, Y', strtotime($oldretreat->end)) }}</td>
                            <td>{{ $oldretreat->directorname }}</td>
                            <td>{{ $oldretreat->innkeepername }}</td>
                            <td>{{ $oldretreat->assistantname }}</td>
                            <td>{{ $oldretreat->attending}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop