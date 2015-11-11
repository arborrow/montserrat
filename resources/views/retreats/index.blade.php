@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">MRH Retreat Index</span> 
                    <span class="create"><a href={{ action('RetreatsController@create') }}>{!! Html::image('img/create.png', 'Create a Retreat',array('title'=>"Create Retreat",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if ($retreats->isEmpty())
                    <p> Currently, there are no retreats!</p>
                @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Title</th>
                            <th>Starts</th>
                            <th>Ends</th>
                            <th>Director</th>
                            <th># Attending</th>
                            <th>Silent</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($retreats as $retreat)
                        <tr>
                            <td><a href="retreat/{{ $retreat->id}}">{{ $retreat->idnumber}}</a></td>
                            <td>{{ $retreat->title }}</td>
                            <td>{{ date('F d, Y', strtotime($retreat->start)) }}</td>
                            <td>{{ date('F d, Y', strtotime($retreat->end)) }}</td>
                            <td>{{ $retreat->directorid }}</td>
                            <td>{{ $retreat->attending}}</td>
                            <td>{{ $retreat->silent ? 'Yes' : 'No'}}</td>
                            <td><a href="{{ action('RetreatsController@edit', $retreat->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></td>
<td>{!! Form::open(['method' => 'DELETE', 'route' => ['retreat.destroy', $retreat->id]]) !!}
 {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger']) !!} 
{!! Form::close() !!}
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