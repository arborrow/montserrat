@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Gate configuration</h2>
            </div>
            @can('show-admin-menu')
                <div class='row'>
                    <div class='col-lg-6 col-md-9'>
                        <strong>Gate Number (GATE_NUMBER): </strong> @if(null!==config('settings.gate_number')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('settings.gate_number') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Open Hours (OPEN_HOURS_DIGITS): </strong>  @if(null!==config('settings.open_hours_digits')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('settings.open_hours_digits') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>End Call (END_CALL_DIGITS): </strong>  @if(null!==config('settings.end_call_digits')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('settings.end_call_digits') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Open (OPEN_DIGITS): </strong>  @if(null!==config('settings.open_digits')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('settings.open_digits') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Close (CLOSE_DIGITS): </strong>  @if(null!==config('settings.close_digits')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('settings.close_digits') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                    </div>
                </div>
            @endCan

    </div>
</section>
@stop
