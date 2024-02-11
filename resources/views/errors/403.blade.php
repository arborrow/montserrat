@extends('template')
@section('content')
<div class="row">
	<div class="col-lg-12 text-center">
		<div class="text-danger"> Oops! 403 - Looks like you do not have access to this page.<br />
			{{ html()->img(asset('images/403.png'), '403 Error')->attribute('title', "403 Error") }}
		</div>
	</div>
</div>
@stop