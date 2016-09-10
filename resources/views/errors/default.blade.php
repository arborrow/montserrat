@extends('template')
@section('content')
    <div class="content">
        <div class="text-danger"> Oops! Looks like Fr. Anthony is using the SQL to corrupt Polanco.<br />
        {!! Html::image('img/error.png', 'System Error',array('title'=>"General Error")) !!}
        </div>
        <p>{{$e}}</p>
    </div>
@stop