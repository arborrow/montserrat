@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create payment for <a href="{{url('donation/'.$donation->donation_id)}}">Donation {{$donation->donation_id}}</a></strong></h2>
        {!! Form::open(['url' => 'payment', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        {!! Form::hidden('donation_id', $donation->donation_id) !!}
            <span>
            
            <h2>Payment detail</h2>
            <div class='row'>
                {!! Form::label('payment_date', 'Payment date:', ['class' => 'col-md-3'])  !!}
                {!! Form::date('payment_date',\Carbon\Carbon::now() , ['class' => 'col-md-3','data-provide'=>'datepicker']) !!}
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
                {!! Form::label('note', 'Note:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('note', NULL, ['class' => 'col-md-3']) !!}                   
            </div> 

            <hr />
            
            <h2>Donation detail</h2>
            <br /><strong>Date: </strong>{{$donation->donation_date}}
            <br /><strong>Description: </strong>{{$donation->donation_description}}  
            <br /><strong>Pledged/Paid: </strong>${{number_format($donation->donation_amount,2)}} / ${{number_format($donation->payments->sum('payment_amount'),2)}}  
            ({{number_format($donation->percent_paid,0)}}%)
            <br /><strong>Terms: </strong>{{$donation->terms}}
            <br /><strong>Notes: </strong>{{$donation->notes}}
            <br /><strong>Start date: </strong>{{$donation->start_date}}
            <br /><strong>End date: </strong>{{$donation->end_date}}
            <br /><strong>Donation install: </strong>{{$donation->donation_install}}
            <br /><hr />
            <div class="col-md-1">
                <div class="form-group">
                    {!! Form::submit('Add payment', ['class'=>'btn btn-primary']) !!}
                </div>
                    {!! Form::close() !!}
            </div>
            <div class="clearfix"></div>
        </span>
    </div>
</section>
@stop