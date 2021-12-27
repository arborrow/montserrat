@extends('template')
@section('content')
<div class="row">
	<div class="col-lg-12 text-center">
		<div class="text-danger"> Oops! 404 - I'm confused, what you are looking for cannot be found.<br />
			{!! Html::image('images/404.png', '404 Error',array('title'=>"404 Error")) !!}
		</div>
	</div>
</div>
@stop