@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Google client configuration</h2>
            </div>
            <p>This page displays the status of the Google client configuration.
            @can('show-admin-menu')
                <div class='row'>
                    <div class='col-lg-6 col-md-9'>
                        <strong>Google client id: </strong> @if(null!==config('services.google.client_id')) <div class="alert alert-success alert-important" role="alert">Configured: <br>{{ config('services.google.client_id') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Google secret key: </strong>  @if(null!==config('services.google.client_secret')) <div class="alert alert-success alert-important" role="alert">Configured: <br>{{ config('services.google.client_secret') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Google redirect: </strong>  @if(null!==config('services.google.redirect')) <div class="alert alert-success alert-important" role="alert">Configured: <br>{{ config('services.google.redirect') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                    </div>
                </div>
            @endCan

    </div>
</section>
@stop
