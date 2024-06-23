@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Application configuration</h2>
            </div>
            <p>App configuration
            @can('show-admin-menu')
                <div class='row'>
                    <div class='col-lg-6 col-md-9'>
                        <strong>Environment (APP_ENV): </strong> @if(null!==App::environment()) <div class="alert alert-success alert-important" role="alert">Configured: {{ App::environment() }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Debug (APP_DEBUG): </strong>  @if(null!==config('app.debug')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('app.debug') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Key (APP_KEY): </strong>  @if(null!==config('app.key')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('app.key') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>URL (APP_URL): </strong>  @if(null!==config('app.url')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('app.url') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Domain (APP_DOMAIN): </strong>  @if(null!==config('app.domain')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('app.domain') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf

                        <br /><strong>Cache (CACHE_STORE): </strong>  @if(null!==config('cache.default')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('cache.default') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Session (SESSION_DRIVER): </strong>  @if(null!==config('session.driver')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('session.driver') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Queue (QUEUE_DRIVER): </strong>  @if(null!==config('queue.default')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('queue.default') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf

                        <br /><strong>Database Connection (DB_CONNECTION): </strong>  @if(null!==config('database.default')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('database.default') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf

                        <br /><strong>Self ID (SELF_CONTACT_ID): </strong>  @if(null!==config('polanco.self.id')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('polanco.self.id') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Self Name (SELF_NAME): </strong>  @if(null!==config('polanco.self.name')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('polanco.self.name') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf

                    </div>
                </div>
            @endCan

    </div>
</section>
@stop
