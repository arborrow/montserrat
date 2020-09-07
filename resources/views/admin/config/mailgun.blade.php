@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Mailgun configuration</h2>
            </div>
            <p>This page displays the status of the Mailgun configuration.
            @can('show-admin-menu')
                <div class='row'>
                    <div class='col-md-4'>
                        <strong>Mailgun Domain: </strong> @if(null!==config('services.mailgun.domain')) <div class="alert alert-success  alert-important" role="alert">Configured</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Mailgun secret: </strong>  @if(null!==config('services.mailgun.secret')) <div class="alert alert-success  alert-important" role="alert">Configured</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                    </div>
                </div>
            @endCan

    </div>
</section>
@stop
