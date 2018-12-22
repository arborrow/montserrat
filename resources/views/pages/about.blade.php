@extends('template')
@section('content')
<h1>About the Montserrat Retreat House Database</h1>
<ul>
    <li><a href='https://github.com/arborrow/montserrat'>Version: 0.1 (alpha)</a>
    <li>Author: <a href='mailto:anthony.borrow@montserratretreat.org'>Fr. Anthony Borrow, S.J.</a>
<li>License: <a href='http://opensource.org/licenses/MIT'>MIT License</a>
<li>Designed with <a href='https://laravel.com'>Laravel</a>
<li><div>Icons made by <a href="https://www.freepik.com/" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" 			    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 			    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>        
</ul>
<p>This is an alpha version of the Montserrat Retreat House database. It is a work in progress!<p>
    {!! Html::image('img/codetest.png', 'Code test ;)',array('title'=>"Code test ;)",'style'=>"height: 300px;")) !!}
@stop
