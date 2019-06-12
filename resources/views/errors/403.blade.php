@extends('template')
@section('content')
<div class="row">
	<div class="col-12 text-center">
		<div class="text-danger"> Oops! 403 - Looks like you do not have access to this page.<br />
			{!! Html::image('images/403.png', '403 Error',array('title'=>"403 Error")) !!}
		</div>
	</div>
</div>
@stop