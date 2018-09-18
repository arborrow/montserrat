@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Twilio client configuration</h2>
            </div>
            <p>This page displays the status of the Google client configuration.
            @can('show-admin-menu') 
                <div class='row'>
                    <div class='col-md-4'>
                        <strong>Twilio SID: </strong> @if(null!==env('TWILIO_SID')) <div class="alert alert-success" role="alert">Configured</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Twilio token: </strong>  @if(null!==env('TWILIO_TOKEN')) <div class="alert alert-success" role="alert">Configured</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                    </div>
                </div>
            @endCan

    </div>
</section>
@stop