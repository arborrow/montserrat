@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                    <span>
                        <h2>
                            Mailgun Message Details for #{{$message->id}} - {{ $message->subject }}
                        </h2>
                    </span>
                    <span class="back"><a href={{ action([\App\Http\Controllers\MailgunController::class, 'index']) }}>{{ html()->img(asset('images/news29.png'), 'Message Index')->attribute('title', "Message Index")->class('btn btn-primary') }}</a></span></h1>
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
                            <a href="{{ action([\App\Http\Controllers\MailgunController::class, 'unprocess'], $message->id) }}" class="btn btn-info">{{ html()->img(asset('images/undo.png'), 'Unprocess')->attribute('title', "Unprocess") }}</a>
                        </div>
                    @endCan
                    @can('delete-message')
                        <div class='col-md-1'>
                            {{ html()->form('DELETE', route('mailgun.destroy', [$message->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                            {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                            {{ html()->form()->close() }}
                        </div>
                    @endCan
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </section>
@stop
