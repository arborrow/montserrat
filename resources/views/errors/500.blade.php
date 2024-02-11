@extends('template')
@section('content')
  <div class="row">
  	<div class="col-lg-12 text-center">
        <div class="text-danger">
          Oops! Looks like {{config('polanco.admin_name')}} is using the SQL to corrupt Polanco.<br />
        </div>
        {{ html()->img(asset('images/error.png'), 'System Error')->attribute('title', "System Error") }}
        <p>A report of this error has been submitted to <a href=mailto:{{ config('polanco.admin_email') }}>{{config('polanco.admin_name')}}</a> who will hunt down the error and destroy it.</p>
    </div>
  </div>
@stop
