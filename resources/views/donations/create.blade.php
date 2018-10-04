@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create donation</strong></h2>
        {!! Form::open(['url' => 'donation', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <span>
            
            <div class='row'>
                {!! Form::label('donor_id', 'Donor:', ['class' => 'col-md-3'])  !!}
                @if (isset($defaults['donor_id']))
                    {!! Form::select('donor_id', $donors, $defaults['donor_id'], ['class' => 'col-md-3']) !!}
                @else
                    {!! Form::select('donor_id', $donors, NULL, ['class' => 'col-md-3']) !!}
                @endif
                        
            </div>
            <div class='row'>
                {!! Form::label('event_id', 'Retreat:', ['class' => 'col-md-3'])  !!}
                @if (isset($defaults['event_id']))
                    {!! Form::select('event_id', $retreats, $defaults['event_id'], ['class' => 'col-md-3']) !!}
                @else
                    {!! Form::select('event_id', $retreats, NULL, ['class' => 'col-md-3']) !!}
                @endif
                        
            </div>
            <div class='row'>
                {!! Form::label('donation_date', 'Date of donation:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('donation_date',date('F j, Y g:i A', strtotime(\Carbon\Carbon::now())) , ['class' => 'col-md-3','data-provide'=>'datepicker']) !!}
            </div>
            
            <div class='row'>
                {!! Form::label('donation_amount', 'Donation amount (pledged):', ['class' => 'col-md-3'])  !!}
                {!! Form::number('donation_amount', 0, ['class' => 'col-md-3','step'=>'0.01']) !!}
            </div>
            <div class='row'>
                {!! Form::label('payment_amount', 'Payment amount (paid):', ['class' => 'col-md-3'])  !!}
                {!! Form::number('payment_amount', 0, ['class' => 'col-md-3','step'=>'0.01']) !!}
            </div>
            <div class='row'>
                {!! Form::label('payment_description', 'Payment method:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('payment_description', $payment_methods, NULL, ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('payment_idnumber', 'Check/CC Number:', ['class' => 'col-md-3'])  !!}
                {!! Form::number('payment_idnumber', NULL, ['class' => 'col-md-3']) !!}
            </div>
            
            <div class='row'>
                {!! Form::label('donation_description', 'Description:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('donation_description', $descriptions, 'Retreat Offering', ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('notes1', 'Primary contact:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('notes1', NULL, ['class' => 'col-md-3']) !!}                   
            </div> 
            <div class='row'>
                {!! Form::label('notes', 'Notes:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('notes', NULL, ['class' => 'col-md-3']) !!}                   
            </div> 
                          
            <div class='row'>
                {!! Form::label('terms', 'Terms:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('terms', NULL, ['class' => 'col-md-3']) !!}                   
            </div> 

            <div class='row'>
                {!! Form::label('start_date', 'Start date:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('start_date', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div> 
            <div class='row'>
                {!! Form::label('end_date', 'End date:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('end_date', null, ['class'=>'col-md-2','data-provide'=>'datepicker']) !!}
            </div> 
            <div class='row'>
                {!! Form::label('donation_install', 'Installment:', ['class' => 'col-md-3'])  !!}
                {!! Form::number('donation_install', NULL, ['class' => 'col-md-3']) !!}
            </div>

            
            <div class="col-md-1">
                <div class="form-group">
                    {!! Form::submit('Add donation', ['class'=>'btn btn-primary']) !!}
                </div>
                    {!! Form::close() !!}
            </div>
            <div class="clearfix"></div>
        </span>
    </div>
</section>
@stop