@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Retreat Waitlist Touchpoint for {{$retreat->title}}</strong></h2>
        {{ html()->form('POST', url('touchpoint/add_retreat_waitlist'))->class('form-horizontal panel')->open() }}
        <span>
            <h3>A retreat touchpoint will add a touchpoint to each of the retreatants currently on the waitlist.</h3>
            <div class='row'>

                {{ html()->label('Date of contact:', 'touched_at')->class('col-md-3') }}
                {{ html()->text('touched_at', now())->class('form-control flatpickr-date-time')->required() }}

            </div>
            <div class='row'>
                {{ html()->label('Name of Retreat:', 'event_id')->class('col-md-3') }}
                {{ html()->select('event_id', [$defaults['event_id'] => $defaults['event_description']], $defaults['event_id'])->class('col-md-3') }}

            </div>
            <div class='row'>
                {{ html()->label('Contacted by:', 'staff_id')->class('col-md-3') }}
                @if (isset($defaults['user_id']))
                    {{ html()->select('staff_id', $staff, $defaults['user_id'])->class('col-md-3') }}
                @else
                    {{ html()->select('staff_id', $staff)->class('col-md-3') }}

                @endif

            </div>

            <div class='row'>
                {{ html()->label('Type of Contact:', 'type')->class('col-md-3') }}
                {{ html()->select('type', ['Call' => 'Call', 'Email' => 'Email', 'Face' => 'Face to Face', 'Letter' => 'Letter', 'Other' => 'Other'])->class('col-md-3') }}

            </div>
            <div class='row'>
                {{ html()->label('Notes:', 'notes')->class('col-md-3') }}
                {{ html()->textarea('notes')->class('col-md-3') }}
            </div>

        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {{ html()->submit('Add Retreat Waitlist Touchpoint')->class('btn btn-primary') }}
            </div>
                {{ html()->form()->close() }}
        </div>
    </span>
    </div>
</section>
@stop
