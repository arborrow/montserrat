@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>Parish: {!! $parish->name !!} (<a href="../diocese/{{$parish->diocese_id}}">{{ $parish->diocese}}</a>)  </span>
                    <span class="back"><a href={{ action('ParishesController@index') }}>{!! Html::image('img/parish.png', 'Parish Index',array('title'=>"Parish Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Address 1: </strong>{{ $parish->address1}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Address 2: </strong>{{ $parish->address2}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>City: </strong>{{ $parish->city}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>State: </strong>{{ $parish->state}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Zip: </strong>{{ $parish->zip}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Phone: </strong>{{ $parish->phone}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Fax: </strong>{{ $parish->fax}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Email: </strong>{{ $parish->email}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Webpage: </strong><a href="{{ $parish->webpage}}" target='_blank'>{{ $parish->webpage}}</a></div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Pastor: </strong>{{ $parish->pastor_id}} (Not yet implemented)</div>
                </div><div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-6'><strong>Notes: </strong>{{ $parish->notes}}</div>
                </div><div class="clearfix"> </div>
            </div>    
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('ParishesController@edit', $parish->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['parish.destroy', $parish->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
        </div>
    </section>
@stop