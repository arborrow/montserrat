@extends('template')
@section('content')
    <div class="content">
        <div class="text-info"> Hasta la vista baby! - Looks like you have logged out.<br />
        {!! Html::image('img/goodbye.png', 'Logged out',array('title'=>"Logged out")) !!}
        </div>
    </div>
@stop