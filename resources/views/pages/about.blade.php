@extends('template')
@section('content')
<h1>About the Montserrat Retreat House Database</h1>
<ul>
    <li><a href='https://github.com/arborrow/montserrat'>Version: 0.1 (alpha)</a>
    <li>Author: <a href='mailto:anthony.borrow@montserratretreat.org'>Fr. Anthony Borrow, S.J.</a>
<li>License: <a href='http://opensource.org/licenses/MIT'>MIT License</a>
</ul>
<p>This is an alpha version of the Montserrat Retreat House database. It is a work in progress!<p>
    {!! Html::image('img/codetest.png', 'Code test ;)',array('title'=>"Code test ;)",'style'=>"height: 300px;")) !!}
        
@stop
