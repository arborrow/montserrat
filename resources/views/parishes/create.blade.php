@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Add A Parish</strong></h2>
            {!! Form::open(['url' => 'parish', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
           <div class="form-group">

                {!! Form::label('diocese_id', 'Diocese:', ['class' => 'col-md-1']) !!}
                {!! Form::select('diocese_id', $dioceses, 0, ['class' => 'col-md-2']) !!}
                
            </div><div class="clearfix"> </div>
           <div class="form-group">

                {!! Form::label('pastor_id', 'Pastor:', ['class' => 'col-md-1']) !!}
                {!! Form::select('pastor_id', $pastors, 0, ['class' => 'col-md-2']) !!}
               
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('name', 'Name:', ['class' => 'col-md-1']) !!}
                {!! Form::text('name', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('address1', 'Address:', ['class' => 'col-md-1']) !!}
                {!! Form::text('address1', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('address2', 'Address2:', ['class' => 'col-md-1']) !!}
                {!! Form::text('address2', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('city', 'City:', ['class' => 'col-md-1']) !!}
                {!! Form::text('city', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('state', 'State:', ['class' => 'col-md-1']) !!}
                {!! Form::text('state', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('zip', 'Zip:', ['class' => 'col-md-1']) !!}
                {!! Form::text('zip', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('phone', 'Phone:', ['class' => 'col-md-1']) !!}
                {!! Form::text('phone', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('fax', 'Fax:', ['class' => 'col-md-1']) !!}
                {!! Form::text('fax', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('email', 'Email:', ['class' => 'col-md-1']) !!}
                {!! Form::text('email', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('webpage', 'Webpage:', ['class' => 'col-md-1']) !!}
                {!! Form::text('webpage', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
                {!! Form::textarea('notes', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
            <div class="col-md-1"><div class="form-group">
                {!! Form::submit('Add Parish', ['class'=>'btn btn-primary']) !!}
            </div></div>
                {!! Form::close() !!}
        </div>
    </section>

@stop