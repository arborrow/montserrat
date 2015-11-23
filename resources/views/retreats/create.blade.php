@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Add A Retreat</strong></h2>
            {!! Form::open(['url' => 'retreat', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            <div class="form-group">
                {!! Form::label('idnumber', 'ID#: ', ['class' => 'col-md-1']) !!}
                {!! Form::text('idnumber', null, ['class' => 'col-md-1']) !!}
                
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('start', 'Starts: ', ['class' => 'col-md-1']) !!}
                {!! Form::text('start', null, ['id' => 'startdate', 'class' => 'col-md-2']) !!}
                <!-- {!! Form::input('date', 'start', date('Y-m-d'), ['class'=>'col-md-2']) !!} -->
                {!! Form::label('end', 'Ends: ', ['class' => 'col-md-1']) !!}
                {!! Form::text('end', null, ['id' => 'enddate', 'class' => 'col-md-2','data-provide'=>'datepicker']) !!}
                <!-- {!! Form::input('date', 'end', Carbon\Carbon::now()->addDays(3)->format('Y-m-d'), ['class'=>'col-md-2']) !!} -->
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('title', 'Title:', ['class' => 'col-md-1']) !!}
                {!! Form::text('title', null, ['class'=>'col-md-2']) !!}
                {!! Form::label('attending', 'Attending:', ['class' => 'col-md-1']) !!}
                {!! Form::text('attending', 0, ['class'=>'col-md-1']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:', ['class' => 'col-md-1']) !!}
                {!! Form::textarea('description', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('directorid', 'Director ID:', ['class' => 'col-md-1']) !!}
                {!! Form::select('directorid', array('0' => 'Not assigned', '3' => 'Ron Boudreaux', '1' => 'Anthony Borrow', '4' => 'John Payne'), 0, ['class' => 'col-md-2']) !!}
                {!! Form::label('innkeeperid', 'Innkeeper ID:', ['class' => 'col-md-1']) !!}
                {!! Form::select('innkeeperid', array('0' => 'Not assigned', '3' => 'Ron Boudreaux', '1' => 'Anthony Borrow', '4' => 'John Payne'), 0, ['class' => 'col-md-2']) !!}
                {!! Form::label('assistantid', 'Assistant ID:', ['class' => 'col-md-1']) !!}
                {!! Form::select('assistantid', array('0' => 'Not assigned', '3' => 'Ron Boudreaux', '1' => 'Anthony Borrow', '4' => 'John Payne'), 0, ['class' => 'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            
            <div class="form-group">
                {!! Form::label('type', 'Type: (Men, Women, Open, Couples, Other)', ['class' => 'col-md-3']) !!}
                {!! Form::text('type', null, ['class'=>'col-md-1']) !!}
               <div class='left-checkbox'> {!! Form::label('silent', 'Silent:', ['class' => 'col-md-1']) !!}
                {!! Form::text('silent', 1, ['class'=>'col-md-1']) !!}</div>
                {!! Form::label('amount', 'Amount:', ['class' => 'col-md-1']) !!}
                {!! Form::text('amount', 390, ['class'=>'col-md-1']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('year', 'Year:', ['class' => 'col-md-1']) !!}
                {!! Form::text('year', 2015, ['class'=>'col-md-1']) !!}
            </div><div class="clearfix"> </div>
            <div class="col-md-1"><div class="form-group">
                {!! Form::submit('Add Retreat', ['class'=>'btn btn-primary']) !!}
            </div></div>
                {!! Form::close() !!}
        </div>
    </section>

@stop