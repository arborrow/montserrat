@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Google client configuration</h2>
            </div>
            <p>This page displays the status of the Google Calendar configuration.
            @can('show-admin-menu')
                <div class='row'>
                    <div class='col-lg-6 col-md-9'>
                        <strong>Google Calendar ID: </strong> @if(null!==config('settings.google_calendar_id')) <div class="alert alert-success alert-important" role="alert">Configured: <br>{{ config('settings.google_calendar_id') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Google Calendar Credentials JSON file: </strong>  @if(null!==config('google-calendar.auth_profiles.service_account.credentials_json')) <div class="alert alert-success alert-important" role="alert">Configured: <br>{{ config('google-calendar.auth_profiles.service_account.credentials_json') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                    </div>
                </div>
            @endCan

    </div>
</section>
@stop
