@extends('template')
@section('content')
<div class="row bg-cover">
	<div class="col-12">
		<h2>Create Touchpoint</h2>
    </div>
	<div class="col-12">
        {!! Form::open(['url' => 'touchpoint', 'method' => 'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('touched_at', 'Date of contact: ')  !!}
                        {!! Form::text('touched_at', now(), ['class'=>'form-control flatpickr-date', 'required']) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('person_id', 'Name of Contact:') !!}
                        @if (isset($defaults['contact_id']))
                            {!! Form::select('person_id', $persons, $defaults['contact_id'], ['class' => 'form-control', 'required']) !!}
                        @else
                            {!! Form::select('person_id', $persons, NULL, ['class' => 'form-control', 'required']) !!}
                        @endif
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="contacted-by">Contacted By</label>
                        @if (isset($defaults['user_id']))
                        {!! Form::select('staff_id', $staff, $defaults['user_id'], ['class' => 'form-control', 'required']) !!}
                        @else
                        {!! Form::select('staff_id', $staff, NULL, ['class' => 'form-control', 'required']) !!}
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('type', 'Type of Contact:') !!}
                        {!! Form::select('type', [
                        'Call' => 'Call',
                        'Email' => 'Email',
                        'Face' => 'Face to Face',
                        'Letter' => 'Letter',
                        'Other' => 'Other',
                        ], NULL, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {!! Form::label('notes', 'Notes:') !!}
                        {!! Form::textarea('notes', NULL, ['class' => 'form-control', 'rows' => '3', 'required']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center mt-3">
                        {!! Form::submit('Add Touchpoint', ['class'=>'btn btn-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
	</div>
</div>
@stop
