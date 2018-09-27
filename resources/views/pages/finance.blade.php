@extends('template')
@section('content')
<h1>Welcome to the Finance Page</h1>
<p>Finance reports</p>
@can('show-donation')
        {!! Html::link(action('PageController@finance_cash_deposit',now()->format('Ymd')),'Cash/Check bank deposit report',array('class' => 'btn btn-default'))!!}
        {!! Html::link(action('PageController@finance_cc_deposit',now()->format('Ymd')),'Credit Card (Internet) bank deposit report',array('class' => 'btn btn-default'))!!}
        {!! Html::link(action('PageController@finance_retreatdonations','201601'),'Retreat donation report',array('class' => 'btn btn-default'))!!}
        {!! Html::link(action('PageController@finance_deposits'),'Deposits report',array('class' => 'btn btn-default'))!!}
@endCan
               
@stop