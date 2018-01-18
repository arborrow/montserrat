@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <h2><strong>Add A Diocese</strong></h2>
            {!! Form::open(['url' => 'diocese', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            
            <div class="form-group">
                {!! Form::label('bishop_id', 'Bishop:', ['class' => 'col-md-1']) !!}
                {!! Form::select('bishop_id', $bishops, 0, ['class' => 'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('organization_name', 'Name:', ['class' => 'col-md-1']) !!}
                {!! Form::text('organization_name', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('street_address', 'Address:', ['class' => 'col-md-1']) !!}
                {!! Form::text('street_address', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('supplemental_address_1', 'Address2:', ['class' => 'col-md-1']) !!}
                {!! Form::text('supplemental_address_1', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('city', 'City:', ['class' => 'col-md-1']) !!}
                {!! Form::text('city', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('state_province_id', 'State:', ['class' => 'col-md-1']) !!}
                {!! Form::select('state_province_id', $states, $defaults['state_province_id'], ['class' => 'col-md-2']) !!}
            
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('postal_code', 'Zip:', ['class' => 'col-md-1']) !!}
                {!! Form::text('postal_code', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('phone_main_phone', 'Phone:', ['class' => 'col-md-1']) !!}
                {!! Form::text('phone_main_phone', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('phone_main_fax', 'Fax:', ['class' => 'col-md-1']) !!}
                {!! Form::text('phone_main_fax', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('email_main', 'Email:', ['class' => 'col-md-1']) !!}
                {!! Form::text('email_main', null, ['class'=>'col-md-2']) !!}
            </div><div class="clearfix"> </div>
            <div class="form-group">
                {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
                {!! Form::textarea('notes', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
            </div><div class="clearfix"> </div>
            <div class='form-group'>
                @include('dioceses.create.urls')
            </div>
            <div class="clearfix"> </div>
    
            <div class="col-md-1"><div class="form-group">
                {!! Form::submit('Add Diocese', ['class'=>'btn btn-primary']) !!}
            </div></div><div class="clearfix"> </div>
                {!! Form::close() !!}
        </div>
    </section>

@stop