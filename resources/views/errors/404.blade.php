@extends('template')
@section('content')
    <div class="content">
        <div class="text-danger"> Oops! 404 - I'm confused, what you are looking for cannot be found.<br />
        {!! Html::image('img/404.png', '404 Error',array('title'=>"404 Error")) !!}
        </div>
    </div>
@stop