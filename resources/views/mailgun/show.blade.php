@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                    <span>
                        <h2>
                            @can('update-message')
                                <a href="{{url('message/'.$message->id.'/edit')}}">{{ $message->subject }}</a>
                            @else
                                {{ $message->subject }}
                            @endCan
                        </h2>
                    </span>
                    <span class="back"><a href={{ action([\App\Http\Controllers\MailgunController::class, 'index']) }}>{!! Html::image('images/message.png', 'Message Index',array('title'=>"Message Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Timestamp: </strong>{{ $message->mailgun_timestamp}}</div>
                    <div class='col-md-3'><strong>Recipients: </strong>{{ $message->recipients}}</div>
                    <div class='col-md-3'><strong>From: </strong>{{ $message->from}}</div>
                    <div class='col-md-3'><strong>To: </strong>{{ $message->to}}</div>
                </div><div class="clearfix"> </div>
                <hr />
                <div class='row'>
                    <div class='col-md-6'><strong>Subject: </strong>{{ $message->subject}}</div>
                </div><div class="clearfix"> </div>
                <hr />
                <div class='row'>
                    <div class='col-md-12'><strong>Body: </strong>{!! str_replace("\n","<br>",$message->body) !!}</div>
                </div><div class="clearfix"> </div>
                <hr />
                <div class='row'>
                    <div class='col-md-12'><strong>Processed: </strong>{{ $message->is_processed ? 'Yes':'No' }}</div>
                </div><div class="clearfix"> </div>

                <div class='row'>
                    @can('update-message')
                        <div class='col-md-1'>
                            <a href="{{ action([\App\Http\Controllers\MailgunController::class, 'edit'], $message->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                        </div>
                    @endCan
                    @can('delete-message')
                        <div class='col-md-1'>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['mailgun.destroy', $message->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                            {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                            {!! Form::close() !!}
                        </div>
                    @endCan
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </section>
@stop
