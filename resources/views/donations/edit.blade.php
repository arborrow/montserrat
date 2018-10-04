@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Donation:</strong></h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['donation.update', $donation->donation_id]]) !!}
    {!! Form::hidden('donation_id', $donation->donation_id) !!}
    {!! Form::hidden('donor_id', $donation->contact_id) !!}
    
        <span>
            <h2>Donation details</h2>
                <div class="form-group">
                    <div class='row'>
                        {!! Form::label('event_id', 'Retreat:', ['class' => 'col-md-2'])  !!}
                        @if (isset($defaults['event_id']))
                            {!! Form::select('event_id', $retreats, $defaults['event_id'], ['class' => 'col-md-3']) !!}
                        @else
                            {!! Form::select('event_id', $retreats, $donation->event_id, ['class' => 'col-md-3']) !!}
                        @endif
                    </div>
                    <div class='row'>
                        {!! Form::label('donation_date', 'Date:', ['class' => 'col-md-2'])  !!}
                        {!! Form::date('donation_date', $donation->donation_date, ['class'=>'col-md-3','data-provide'=>'datepicker']) !!}
            
                    </div>
                    <div class='row'>
                        {!! Form::label('donation_amount', 'Amount:', ['class' => 'col-md-2'])  !!}
                        {!! Form::number('donation_amount', $donation->donation_amount, ['class' => 'col-md-3','step'=>'0.01']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('donation_description', 'Description: ', ['class' => 'col-md-2'])  !!}
                        {!! Form::select('donation_description', $descriptions, $defaults['description_key'], ['class' => 'col-md-3']) !!}
            
                    </div>
                    
                    <div class='row'>
                        {!! Form::label('notes1', 'Primary contact:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('notes1', $donation->Notes1, ['class' => 'col-md-3']) !!}                   
                    </div> 
                    <div class='row'>
                        {!! Form::label('notes', 'Notes:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('notes', $donation->Notes, ['class' => 'col-md-3']) !!}                   
                    </div> 
                    <div class='row'>
                        {!! Form::label('terms', 'Terms:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('terms', $donation->terms, ['class' => 'col-md-3']) !!}                   
                    </div> 
                    
                    <div class='row'>
                        {!! Form::label('start_date_only', 'Start date:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('start_date_only', $donation->start_date, ['class' => 'col-md-3','data-provide'=>'datepicker']) !!}                   
                    </div> 
                    <div class='row'>
                        {!! Form::label('end_date_only', 'End date:', ['class' => 'col-md-2'])  !!}
                        {!! Form::text('end_date_only', $donation->end_date, ['class' => 'col-md-3','data-provide'=>'datepicker']) !!}                   
                    </div> 
                    <div class='row'>
                        {!! Form::label('donation_install', 'Installment:', ['class' => 'col-md-2'])  !!}
                        {!! Form::number('donation_install', $donation->install, ['class' => 'col-md-3']) !!}
                    </div>

                </div>
            </span>
                

    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop