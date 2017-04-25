@extends('template')
@section('content')
    <div class="content">
        <div class="text-danger"> Oops! 403 - Looks like you do not have access to this page.<br />
        {!! Html::image('img/403.png', '403 Error',array('title'=>"403 Error")) !!}
        </div>
    </div>
@stop