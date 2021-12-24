@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Configuration settings index</h2>
            </div>
            <div>
                <p>
                  Polanco configuration settings
                </p>
                <select class="custom-select col-3" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="">Select configuration report ...</option>
                    <option value="{{url('admin/config/application')}}">App settings</option>
                    <option value="{{url('admin/config/gate')}}">Gate settings</option>
                    <option value="{{url('admin/config/google_calendar')}}">Google calendar</option>
                    <option value="{{url('admin/config/google_client')}}">Google client</option>
                    <option value="{{url('admin/config/mail')}}">Mail settings</option>
                    <option value="{{url('admin/config/mailgun')}}">Mailgun settings</option>
                    <option value="{{url('admin/phpinfo')}}">PHP Info report</option>
                    <option value="{{url('admin/config/twilio')}}">Twilio settings</option>
                </select>

            </div>
        </div>
    </div>
</section>
@stop
