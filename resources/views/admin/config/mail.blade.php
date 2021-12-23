@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Mail configuration</h2>
            </div>
            @can('show-admin-menu')
                <div class='row'>
                    <div class='col-lg-6 col-md-9'>
                      <br /><strong>Mailer: </strong>  @if(null!==config('mail.default')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('mail.default') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Host (MAIL_HOST): </strong>  @if(null!==config('mail.mailers.'. config('mail.default') . '.host')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('mail.mailers.'. config('mail.default') . '.host') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Port (MAIL_PORT): </strong>  @if(null!==config('mail.mailers.'. config('mail.default') . '.port')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('mail.mailers.'. config('mail.default') . '.port') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Username (MAIL_USERNAME): </strong>  @if(null!==config('mail.mailers.'. config('mail.default') . '.username')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('mail.mailers.'. config('mail.default') . '.username') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Password (MAIL_PASSWORD): </strong>  @if(null!==config('mail.mailers.'. config('mail.default') . '.password')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('mail.mailers.'. config('mail.default') . '.password') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>Encryption (MAIL_ENCRYPTION): </strong>  @if(null!==config('mail.mailers.'. config('mail.default') . '.encryption')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('mail.mailers.'. config('mail.default') . '.encryption') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>From Name (MAIL_FROM_NAME): </strong>  @if(null!==config('mail.from.name')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('mail.from.name') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                        <br /><strong>From Address (MAIL_FROM_ADDRESS): </strong>  @if(null!==config('mail.from.name')) <div class="alert alert-success alert-important" role="alert">Configured: {{ config('mail.from.address') }}</div> @else <div class="alert alert-warning" role="alert">Not configured</div> @endIf
                    </div>
                </div>
            @endCan

    </div>
</section>
@stop
