@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h1>Retreat #{!! $ret->id !!}</span>
                    <span class="back"><a href={{ action('RetreatsController@index') }}>{!! Html::image('img/retreat.png', 'Retreat Index',array('title'=>"Retreat Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                <div class='row'>
                    <div class='col-md-2'><strong>ID#: </strong>{{ $ret->id}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Starts: </strong>{{ $ret->start}}</div>
                    <div class='col-md-3'><strong>Ends: </strong>{{ $ret->end}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Title: </strong>{{ $ret->title}}</div>
                    <div class='col-md-3'><strong>Attending: </strong>{{ $ret->attending}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Description: </strong>{{ $ret->description}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Director ID: </strong>{{ $ret->directorid}}</div>
                    <div class='col-md-3'><strong>Innkeeper ID: </strong>{{ $ret->innkeeperid}}</div>
                    <div class='col-md-3'><strong>Assistant ID: </strong>{{ $ret->assistantid}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Type: </strong>{{ $ret->type}}</div>
                    <div class='col-md-3'><strong>Silent: </strong>{{ $ret->silent}}</div>
                    <div class='col-md-3'><strong>Donation: </strong>{{ $ret->amount}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-2'><strong>Year: </strong>{{ $ret->year}}</div>
                </div><div class="clearfix"> </div>
                </tbody>
                </table></div>
            </div>
        </div>
    </section>
@stop