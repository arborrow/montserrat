@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Touchpoint</strong></h2>
        {!! Form::open(['url' => 'touchpoint', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <span>
            <div class='row'>
                {!! Form::label('touched_at', 'Date of contact:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('touched_at',date('F j, Y g:i A', strtotime(\Carbon\Carbon::now())) , ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('person_id', 'Name of Contact:', ['class' => 'col-md-3'])  !!}
                @if (isset($defaults['contact_id']))
                    {!! Form::select('person_id', $persons, $defaults['contact_id'], ['class' => 'col-md-3']) !!}
                @else
                    {!! Form::select('person_id', $persons, NULL, ['class' => 'col-md-3']) !!}
                @endif
                        
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