@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Edit payment for <a href="{{url('donation/'.$payment->donation->donation_id)}}">Donation {{$payment->donation->donation_id}}</a></strong></h2>
           {!! Form::open(['method' => 'PUT', 'route' => ['payment.update', $payment->payment_id]]) !!}
           {!! Form::hidden('donation_id', $payment->donation->donation_id) !!}
           <span>
            
            <h2>Payment detail</h2>
            <div class='row'>
                {!! Form::label('payment_date', 'Payment date:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('payment_date', date('F j, Y', strtotime($payment->payment_date)), ['class' => 'col-md-3']) !!}    
            </div>
                           
            <div class='row'>
                {!! Form::label('payment_amount', 'Payment amount (paid):', ['class' => 'col-md-3'])  !!}
                {!! Form::number('payment_amount', $payment->payment_amount, ['class' => 'col-md-3','step'=>'0.01']) !!}
            </div>
            <div class='row'>
                {!! Form::label('payment_description', 'Payment method:', ['class' => 'col-md-3'])  !!}
                {!! Form::select('payment_description', $payment_methods, $payment->payment_description, ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('payment_idnumber', 'Check/CC Number:', ['class' => 'col-md-3'])  !!}
                {!! Form::number('payment_idnumber', $payment->payment_number, ['class' => 'col-md-3']) !!}
            </div>

            <div class='row'>
                {!! Form::label('note', 'Note:', ['class' => 'col-md-3'])  !!}
                {!! Form::text('note', $payment->note, ['class' => 'col-md-3']) !!}                   
            </div> 

            <hr />
            
            <h2>Donation detail</h2>
            <br /><strong>Date: </strong>{{$payment->donation->donation_date}}
            <br /><strong>Description: </strong>{{$payment->donation->donation_description}}  
            <br /><strong>Pledged/Paid: </strong>${{number_format($payment->donation->donation_amount,2)}} / ${{number_format($payment->donation->payments->sum('payment_amount'),2)}}  
            ({{number_format($payment->donation->percent_paid,0)}}%)
            <br /><strong>Terms: </strong>{{$payment->donation->terms}}
            <br /><strong>Notes: </strong>{{$payment->donation->notes}}
            <br /><strong>Start date: </strong>{{$payment->donation->start_date}}
            <br /><strong>End date: </strong>{{$payment->donation->end_date}}
            <br /><strong>Donation install: </strong>{{$payment->donation->donation_install}}
            <br /><hr />
            <div class="col-md-1">
                <div class="form-group">
                    {!! Form::submit('Update payment', ['class'=>'btn btn-primary']) !!}
                </div>
                    {!! Form::close() !!}
            </div>
            <div class="clearfix"></div>
        </span>
    </div>
</section>
@stop