@extends('template')
@section('content')
<h1>Welcome to the Finance Page</h1>
<p>Finance reports</p>
@can('show-donation')
        {!! Html::link(action('PageController@finance_bankdeposit',now()->format('Ymd')),'Bank deposit report',array('class' => 'btn btn-default'))!!}
        {!! Html::link(action('PageController@finance_retreatdonations','201601'),'Retreat donation report',array('class' => 'btn btn-default'))!!}
        {!! Html::link(action('PageController@finance_deposits'),'Deposits report',array('class' => 'btn btn-default'))!!}
@endCan
               
@stop