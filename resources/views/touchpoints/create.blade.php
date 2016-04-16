@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Touch point</strong></h2>
        {!! Form::open(['url' => 'touchpoint', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <span>
            <div class='row'>
                {!! Form::label('touched_at', 'Date of contact:', ['class' => 'col-md-3'])  !!}

                {!! Form::text('touched_at', \Carbon\Carbon::now() , ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('person_id', 'Name of Contact:', ['class' => 'col-md-3'])  !!}
                @if (isset($contact_id))
                    {!! Form::select('person_id', $persons, $contact_id, ['class' => 'col-md-3']) !!}
                @else
                    {!! Form::select('person_id', $persons, NULL, ['class' => 'col-md-3']) !!}
                @endif
                        
            </div>
            <div class='row'>
                {!! Form::label('staff_id', 'Contacted by:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('staff_id', $staff, NULL, ['class' => 'col-md-3']) !!}
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
                {!! Form::submit('Add Touch point', ['class'=>'btn btn-primary']) !!}
            </div>
                {!! Form::close() !!}
        </div>
    </span>
    </div>
</section>
@stop