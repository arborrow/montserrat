@extends('template')
@section('content')
<div class="row bg-cover">
	<div class="col-lg-12">
        <h2><strong>Create Retreat Touchpoint for {{$retreat->title}}</strong></h2>
        <h3>A retreat touchpoint will add a touchpoint to each of the retreat participants.</h3>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('touchpoint/add_retreat'))->class('form-horizontal panel')->open() }}
            <div class="form-group">
                <div class='row'>
                        {{ html()->label('Date of contact:', 'touched_at')->class('col-lg-2') }}
                        {{ html()->text('touched_at', now())->class('col-lg-6 form-control flatpickr-date-time required') }}

                </div>
                <div class='row'>
                        {{ html()->label('Name of Retreat:', 'event_id')->class('col-lg-2') }}
                        {{ html()->select('event_id', [$defaults['event_id'] => $defaults['event_description']], $defaults['event_id'])->class('col-lg-6') }}

                </div>
                <div class='row'>
                        {{ html()->label('Contacted by:', 'staff_id')->class('col-lg-2') }}
                        @if (isset($defaults['user_id']))
                            {{ html()->select('staff_id', $staff, $defaults['user_id'])->class('col-lg-6') }}
                        @else
                            {{ html()->select('staff_id', $staff)->class('col-lg-6') }}

                        @endif
                </div>
                <div class='row'>
                        {{ html()->label('Type of Contact:', 'type')->class('col-lg-2') }}
                        {{ html()->select('type', ['Call' => 'Call', 'Email' => 'Email', 'Face' => 'Face to Face', 'Letter' => 'Letter', 'Other' => 'Other']) }}
                </div>
                <div class='row'>
                    {{ html()->label('Notes:', 'notes')->class('col-lg-2') }}
                    {{ html()->textarea('notes')->class('col-lg-6') }}

                </div>
            </div>
            <div class='row'>
                    {{ html()->submit('Add Retreat Touchpoint')->class('btn btn-primary') }}
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@stop
