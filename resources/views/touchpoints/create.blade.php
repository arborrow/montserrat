@extends('template')
@section('content')
<div class="row bg-cover">
	<div class="col-lg-12">
		<h2>Create Touchpoint</h2>
    </div>
	<div class="col-lg-12">
        {{ html()->form('POST', 'touchpoint')->open() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Date of contact: ', 'touched_at') }}
                        {{ html()->text('touched_at', now())->class('form-control flatpickr-date-time')->required() }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Name of Contact:', 'person_id') }}
                        @if (isset($defaults['contact_id']))
                            {{ html()->select('person_id', $persons, $defaults['contact_id'])->class('form-control')->required() }}
                        @else
                            {{ html()->select('person_id', $persons)->class('form-control')->required() }}
                        @endif
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label for="contacted-by">Contacted By</label>
                        @if (isset($defaults['user_id']))
                        {{ html()->select('staff_id', $staff, $defaults['user_id'])->class('form-control')->required() }}
                        @else
                        {{ html()->select('staff_id', $staff)->class('form-control')->required() }}
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Type of Contact:', 'type') }}
                        {{ html()->select('type', ['Call' => 'Call', 'Email' => 'Email', 'Face' => 'Face to Face', 'Letter' => 'Letter', 'Other' => 'Other'])->class('form-control')->required() }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ html()->label('Notes:', 'notes') }}
                        {{ html()->textarea('notes')->class('form-control')->rows('3')->required() }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center mt-3">
                        {{ html()->submit('Add Touchpoint')->class('btn btn-primary') }}
                    </div>
                </div>
            {{ html()->form()->close() }}
        </div>
	</div>
</div>
@stop
