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
                        <br /><strong>Pledged/Paid: </strong>${{number_format($donation->donation_amount,2)}} / ${{number_format($donation->payments->sum('payment_amount'),2)}}      
                        <br /><strong>Terms: </strong>{{$donation->terms}}
                        <br /><strong>Notes: </strong>{{$donation->notes}}
                        <br /><strong>Start date: </strong>{{$donation->start_date}}
                        <br /><strong>End date: </strong>{{$donation->end_date}}
                        <br /><strong>Donation install: </strong>{{$donation->donation_install}}
                    
                </div>
            </div>
            <hr />
            <div class='row'>
                <div class='col-md-8'>
                    <table class="table table-bordered table-striped table-hover"><caption><h2>Payments for Donation #{{$donation->donation_id}} - Total payments: ${{number_format($donation->payments->sum('payment_amount'),2)}}</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Check#</th>
                            <th>CC#</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($donation->payments as $payment)
                        <tr>

                            <td style="width:10%"><a href="../payment/{{ $payment->payment_id}}">{{ date('M d, Y g:i A', strtotime($payment->payment_date)) }}</a></td>
                            <td style="width:10%">${{ $payment->payment_amount }} </td>
                            <td style="width:10%">{{$payment->payment_description}}</td>
                            <td style="width:10%">{{ $payment->cknumber}}</td>
                            <td style="width:10%">{{ $payment->ccnumber }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                    
                </table>
                
                   
                </div>
            </div>
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