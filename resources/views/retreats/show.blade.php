@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>Retreat Details for #{!! $retreat->idnumber !!}</span>
                <span class="back"><a href={{ action('RetreatsController@index') }}>{!! Html::image('img/retreat.png', 'Retreat Index',array('title'=>"Retreat Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
            </div>
            <div class='row'>
                <div class='col-md-2'><strong>ID#: </strong>{{ $retreat->idnumber}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Starts: </strong>{{date('F d, Y', strtotime($retreat->start))}}</div>
                <div class='col-md-3'><strong>Ends: </strong>{{date('F d, Y', strtotime($retreat->end))}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Title: </strong>{{ $retreat->title}}</div>
                <div class='col-md-3'><strong>Attending: </strong>{{ $retreat->attending}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-6'><strong>Description: </strong>{{ $retreat->description}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Director ID: </strong> {{ $retreat->directorname}}</div>
                <div class='col-md-3'><strong>Innkeeper ID: </strong>{{ $retreat->innkeepername}}</div>
                <div class='col-md-3'><strong>Assistant ID: </strong>{{ $retreat->assistantname}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Type: </strong>{{ $retreat->type}}</div>
                <div class='col-md-3'><strong>Silent: </strong>{{ $retreat->silent}}</div>
                <div class='col-md-3'><strong>Donation: </strong>{{ $retreat->amount}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-2'><strong>Year: </strong>{{ $retreat->year}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('RetreatsController@edit', $retreat->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['retreat.destroy', $retreat->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
        </div>
        <div class="panel panel-default">  
        <div class="panel-heading">
            <h2>Retreatants Registered</h2>
        </div>
            @if ($registrations->isEmpty())
                <p> Currently, there are no registrations for this retreats</p>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Registered</th>
                        <th>Deposit</th>
                        <th>Mobile Phone</th>
                        <th>Parish</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($registrations as $registration)
                    <tr>
                        <td>{{ $registration->retreatantname}}</td>
                        <td>{{ date('F d, Y', strtotime($registration->register)) }}</td>
                        <td>{{ $registration->deposit }}</td>
                        <td>{{ $registration->retreatantmobilephone}}</td>
                        <td>{{ $registration->retreatantparish}}</td>
                        <td>{{ $registration->notes }}</td>


                    </tr>
                    @endforeach
            </tbody>
</table>@endif
        </div>
    </div>
</section>
@stop