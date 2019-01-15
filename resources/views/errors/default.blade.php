@extends('template')
@section('content')
    <div class="content">
        <div class="text-danger"> Oops! Looks like Fr. Anthony is using the SQL to corrupt Polanco.<br /></div>
        {!! Html::image('images/error.png', 'System Error',array('title'=>"System Error")) !!}
        <p>A report of this error has been submitted to Fr. Anthony who will hunt down the error and destroy it.</p>
    </div>
@stop