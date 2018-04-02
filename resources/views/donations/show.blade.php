@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                        @can('update-donation')
                            <a href="{{url('donation/'.$donation->id.'/edit')}}">Donation details</a> 
                        @else
                            Donation details
                        @endCan
                        for {!!$donation->contact->contact_link_full_name!!}
                </span>                
            </div>
            
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Date: </strong>{{$donation->donation_date}}
                        <br /><strong>Description: </strong>{{$donation->donation_description}}  
                        <br /><strong>Amount: </strong>{{$donation->donation_amount}}     
                        <br /><strong>Terms: </strong>{{$donation->terms}}
                        <br /><strong>Notes: </strong>{{$donation->notes}}
                        <br /><strong>Start date: </strong>{{$donation->start_date}}
                        <br /><strong>End date: </strong>{{$donation->end_date}}
                        <br /><strong>Donation install: </strong>{{$donation->donation_install}}
                    
                </div>
                <div>
                    <strong>Payments: (Date,Amount,Description,Ck#,CC#) </strong>
                    <ul>
                        @foreach($donation->payments as $payment)
                            <li>    {{$payment->payment_date}}, {{$payment->payment_amount}}, {{$payment->payment_description}}, {{$payment->cknumber}},{{$payment->ccnumber}}</li>
                        @endforeach
                    </ul>
                </div>
            </div></div>
            <div class='row'>
                @can('update-donation')
                    <div class='col-md-1'>
                        <a href="{{ action('DonationsController@edit', $donation->donation_id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                    </div>
                @endCan
                @can('delete-donation')
                    <div class='col-md-1'>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['donation.destroy', $donation->donation_id],'onsubmit'=>'return ConfirmDelete()']) !!}
                        {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                        {!! Form::close() !!}
                    </div>
                @endCan
                <div class="clearfix"> </div>
            </div>
    </div>
</section>
@stop