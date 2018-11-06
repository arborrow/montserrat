@extends('template')
@section('content')

<section class="section-padding">
	<div class="jumbotron text-left">
		<h2 class="font-weight-bold">Create Touchpoint</h2>
		<form action="">
			<div class="form-group">
				<label for="contact-date">Date of contact</label>
				<input type="date" class="form-control" id="contact-date" placeholder="MM/DD/YYYY">
			</div>
			<div class="form-group">
				<label for="contact-name">Name of contact</label>
				@if (isset($defaults['contact_id']))
				{!! Form::select('person_id', $persons, $defaults['contact_id'], ['class' => 'col-md-3']) !!}
				@else
				<select class="form-control" id="contact-name">
					@foreach ($persons as $person)
					<option>{{ $person }}</option>	
					@endforeach
				</select>
				@endif
			</div>
			<div class="form-group">
				<label for="contacted-by">Contacted By</label>
				@if (isset($defaults['user_id']))
				{!! Form::select('staff_id', $staff, $defaults['user_id'], ['class' => 'col-md-3']) !!}
				@else
				<select name="form-control" id="contacted-by">
					@foreach ($staff as $s)
					<option>{{ $s }}</option>
					@endforeach
				</select>
				@endif
			</div>
		</form>
		{!! Form::open(['url' => 'touchpoint', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
		<span>
			<div class='row'>
				{!! Form::label('staff_id', 'Contacted by:', ['class' => 'col-md-3']) !!}

			</div>
			<div class='row'>
				{!! Form::label('type', 'Type of Contact:', ['class' => 'col-md-3']) !!}
				{!! Form::select('type', [
				'Call' => 'Call',
				'Email' => 'Email',
				'Face' => 'Face to Face',
				'Letter' => 'Letter',
				'Other' => 'Other',
				], NULL, ['class' => 'col-md-3']) !!}

			</div>
			<div class='row'>
				{!! Form::label('notes', 'Notes:', ['class' => 'col-md-3']) !!}
				{!! Form::textarea('notes', NULL, ['class' => 'col-md-3']) !!}
			</div>
			<div class="col-md-1">
				<div class="form-group">
					{!! Form::submit('Add Touchpoint', ['class'=>'btn btn-primary']) !!}
				</div>
				{!! Form::close() !!}
			</div>
			<div class="clearfix"></div>
		</span>
	</div>
</section>
@stop