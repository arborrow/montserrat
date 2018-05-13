@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                        @can('update-payment')
                            <a href="{{url('payment/'.$payment->payment_id.'/edit')}}">Payment details</a> 
                        @else
                            Payment details
                        @endCan
                        for <a href="{{url('donation/'.$payment->donation->donation_id)}}">Donation #{{$payment->donation->donation_id}}</a> 
                        ({!!$payment->donation->contact->contact_link_full_name!!})
                </span>                
            </div>
            
            
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Date: </strong>{{$payment->payment_date}}
                        <br /><strong>Amount: </strong>${{ number_format($payment->payment_amount,2)}}  
                        <br /><strong>Method: </strong>{{$payment->payment_description}}  
                        <br /><strong>ID#: </strong>{{ $payment->ccnumber or $payment->cknumber}}
                        <br /><strong>Note: </strong>{{$payment->note}}
                    
                </div>
            </div>
            
            <hr />
            <h2>Donation details:</h2>
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Date: </strong> {{$payment->donation->donation_date}}
                        <br /><strong>Description: </strong>{{$payment->donation->donation_description}}  
                        <br /><strong>Amount pledged (% paid): </strong>${{number_format($payment->donation->donation_amount,2)}}
                        ({{number_format($payment->donation->percent_paid,0)}}%)
                        <br /><strong>Terms: </strong>{{$payment->donation->terms}}
                        <br /><strong>Notes: </strong>{{$payment->donation->notes}}
                        <br /><strong>Start date: </strong>{{$payment->donation->start_date}}
                        <br /><strong>End date: </strong>{{$payment->donation->end_date}}
                        <br /><strong>Donation install: </strong>{{$payment->donation->donation_install}}
                    
                </div>
            </div>
            
            
            <div class='row'>
                @can('update-payment')
                    <div class='col-md-1'>
                        <a href="{{ action('PaymentsController@edit', $payment->payment_id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                    </div>
                @endCan
                @can('delete-payment')
                    <div class='col-md-1'>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['payment.destroy', $payment->payment_id],'onsubmit'=>'return ConfirmDelete()']) !!}
                        {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                        {!! Form::close() !!}
                    </div>
                @endCan
                <div class="clearfix"> </div>
            </div>
    </div>
</section>
@stop