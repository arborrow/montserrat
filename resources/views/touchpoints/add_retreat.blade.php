@extends('template')
@section('content')
<div class="row bg-cover">
	<div class="col-lg-12">
        <h2><strong>Create Retreat Touchpoint for {{$retreat->title}}</strong></h2>
        <h3>A retreat touchpoint will add a touchpoint to each of the retreat participants.</h3>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url' => 'touchpoint/add_retreat', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            <div class="form-group">
                <div class='row'>
                        {!! Form::label('touched_at', 'Date of contact:', ['class'=>'col-lg-2'])  !!}
                        {!! Form::text('touched_at', now(), ['class'=>'col-lg-6 form-control flatpickr-date-time required']) !!}

                </div>
                <div class='row'>
                        {!! Form::label('event_id', 'Name of Retreat:', ['class'=>'col-lg-2'])  !!}
                        {!! Form::select('event_id', [$defaults['event_id']=>$defaults['event_description']],$defaults['event_id'], ['class'=>'col-lg-6']) !!}

                </div>
                <div class='row'>
                        {!! Form::label('staff_id', 'Contacted by:', ['class'=>'col-lg-2'])  !!}
                        @if (isset($defaults['user_id']))
                            {!! Form::select('staff_id', $staff, $defaults['user_id'], ['class'=>'col-lg-6']) !!}
                        @else
                            {!! Form::select('staff_id', $staff, NULL, ['class'=>'col-lg-6']) !!}

                        @endif
                </div>
                <div class='row'>
                        {!! Form::label('type', 'Type of Contact:', ['class'=>'col-lg-2'])  !!}
                        {!! Form::select('type', [
                        'Call' => 'Call',
                        'Email' => 'Email',
                        'Face' => 'Face to Face',
                        'Letter' => 'Letter',
                        'Other' => 'Other',
                        ], NULL) !!}
                </div>
                <div class='row'>
                    {!! Form::label('notes', 'Notes:', ['class'=>'col-lg-2'])  !!}
                    {!! Form::textarea('notes', NULL, ['class'=>'col-lg-6']) !!}

                </div>
            </div>
            <div class='row'>
                    {!! Form::submit('Add Retreat Touchpoint', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
