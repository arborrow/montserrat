@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Donation:</strong></h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['donation.update', $donation->donation_id]]) !!}
    {!! Form::hidden('id', $donation->donation_id) !!}
    
        <span>
            <h2>Donation details</h2>
                <div class="form-group">
                    <div class='row'>
                        {!! Form::label('donation_date', 'Date:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('donation_date', date('F j, Y', strtotime($donation->donation_date)), ['class' => 'col-md-3']) !!}
                    </div>
                    <!-- <div class='row'>
                        {!! Form::label('donation_description', 'Description:', ['class' => 'col-md-3'])  !!}
                        {!! Form::select('donation_description', $descriptions, $donation->donation_description, ['class' => 'col-md-3']) !!}
                    </div> -->
                    <div class='row'>
                        {!! Form::label('donation_description', 'Description:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('donation_description', $donation->donation_description, ['class' => 'col-md-3']) !!}
                    </div>
                    
                    <div class='row'>
                        {!! Form::label('donation_amount', 'Amount:', ['class' => 'col-md-3'])  !!}
                        {!! Form::number('donation_amount', $donation->donation_amount, ['class' => 'col-md-3']) !!}
                    </div>
                    
                    <div class='row'>
                        {!! Form::label('terms', 'Terms:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('terms', $donation->terms, ['class' => 'col-md-3']) !!}                   
                    </div> 
                    
                    <div class='row'>
                        {!! Form::label('start_date', 'Start date:', ['class' => 'col-md-3'])  !!}
                        {!! Form::date('start_date', $donation->start_date, ['class' => 'col-md-3']) !!}                   
                    </div> 
                    <div class='row'>
                        {!! Form::label('end_date', 'End date:', ['class' => 'col-md-3'])  !!}
                        {!! Form::date('end_date', $donation->end_date, ['class' => 'col-md-3']) !!}                   
                    </div> 
                    <div class='row'>
                        {!! Form::label('donation_install', 'Installment:', ['class' => 'col-md-3'])  !!}
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