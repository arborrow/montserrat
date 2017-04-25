@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Retreat Touchpoint for {{$retreat->title}}</strong></h2>
        {!! Form::open(['url' => 'touchpoint/add_retreat', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <span>
            <h3>A retreat touchpoint will add a touchpoint to each of the retreat participants.</h3>
            <div class='row'>

                {!! Form::label('touched_at', 'Date of contact:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('touched_at',date('F j, Y g:i A', strtotime(\Carbon\Carbon::now())) , ['class' => 'col-md-3']) !!}

            </div>
            <div class='row'>
                {!! Form::label('event_id', 'Name of Retreat:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('event_id', [$defaults['event_id']=>$defaults['event_description']],$defaults['event_id'], ['class' => 'col-md-3']) !!}
                        
            </div>
            <div class='row'>
                {!! Form::label('staff_id', 'Contacted by:', ['class' => 'col-md-3'])  !!}
                @if (isset($defaults['user_id']))
                    {!! Form::select('staff_id', $staff, $defaults['user_id'], ['class' => 'col-md-3']) !!}
                @else
                    {!! Form::select('staff_id', $staff, NULL, ['class' => 'col-md-3']) !!}
                
                @endif
                
            </div>

            <div class='row'>
                {!! Form::label('type', 'Type of Contact:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('type', [
                'Call' => 'Call',
                'Email' => 'Email',
                'Face' => 'Face to Face',
                'Letter' => 'Letter',
                'Other' => 'Other',
                ], NULL, ['class' => 'col-md-3']) !!}

            </div>
            <div class='row'>
                {!! Form::label('notes', 'Notes:', ['class' => 'col-md-3'])  !!}
                {!! Form::textarea('notes', NULL, ['class' => 'col-md-3']) !!}                   
            </div>             

        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Retreat Touchpoint', ['class'=>'btn btn-primary']) !!}
            </div>
                {!! Form::close() !!}
        </div>
    </span>
    </div>
</section>
@stop