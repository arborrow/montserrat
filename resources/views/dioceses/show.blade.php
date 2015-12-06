@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>{!! $diocese->name !!} ({!! $diocese->bishop !!}) </span>
                    <span class="back"><a href={{ action('DiocesesController@index') }}>{!! Html::image('img/diocese.png', 'Diocese Index',array('title'=>"Diocese Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Address 1: </strong>{{ $diocese->address1}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Address 2: </strong>{{ $diocese->address2}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>City: </strong>{{ $diocese->city}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>State: </strong>{{ $diocese->state}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Zip: </strong>{{ $diocese->zip}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Phone: </strong>{{ $diocese->phone}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Fax: </strong>{{ $diocese->fax}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Email: </strong>{{ $diocese->email}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Webpage: </strong><a href="{{ $diocese->webpage}}" target='_blank'>{{ $diocese->webpage}}</a></div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Pastor: </strong>{{ $diocese->pastor_id}} (Not yet implemented)</div>
                </div><div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-6'><strong>Notes: </strong>{{ $diocese->notes}}</div>
                </div><div class="clearfix"> </div>
            </div>    
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('DiocesesController@edit', $diocese->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['diocese.destroy', $diocese->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
        </div>
    </section>
@stop