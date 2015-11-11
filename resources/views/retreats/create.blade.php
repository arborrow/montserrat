@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Add A Retreat</strong></h2>
            {!! Form::open(['url' => 'retreat', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            <div class="form-group">
                {!! Form::label('idnumber', 'ID#: ') !!}
                {!! Form::text('idnumber', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('title', 'Title:') !!}
                {!! Form::text('title', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('start', 'Start date: (12-25-2015)') !!}
                {!! Form::input('date', 'start', date('Y-m-d'), ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('end', 'End date: (2015-12-11)') !!}
                {!! Form::input('date', 'end', Carbon\Carbon::now()->addDays(3)->format('Y-m-d'), ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('type', 'Type: (Men, Women, Open, Couples, Other)') !!}
                {!! Form::text('type', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('silent', 'Silent:') !!}
                {!! Form::text('silent', 1, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('amount', 'Amount:') !!}
                {!! Form::text('amount', 390, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('year', 'Year:') !!}
                {!! Form::text('year', 2015, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('directorid', 'Director ID:') !!}
                {!! Form::text('directorid', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('innkeeperid', 'Innkeeper ID:') !!}
                {!! Form::text('innkeeperid', null, ['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('assistantid', 'Assistant ID:') !!}
                {!! Form::text('assistantid', null, ['class'=>'form-control']) !!}
            </div>
            
            <div class="form-group">
                {!! Form::submit('Add Retreat', ['class'=>'btn btn-primary']) !!}
            </div>
                {!! Form::close() !!}
        </div>
    </section>

@stop