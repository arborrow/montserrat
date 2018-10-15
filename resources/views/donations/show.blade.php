@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                        @can('update-donation')
                            <a href="{{url('donation/'.$donation->donation_id.'/edit')}}">Donation details</a> 
                        @else
                            Donation details
                        @endCan
                        for {!!$donation->contact->contact_link_full_name!!} <br />
                </span>                
                    {!! Html::link(action('PageController@finance_invoice',$donation->donation_id),'Invoice',array('class' => 'btn btn-default'))!!}
                    @can('create-payment')
                        {!! Html::link(action('PaymentController@create',$donation->donation_id),'Add payment',array('class' => 'btn btn-default'))!!}
                    @endCan    
            </div>
            
            <div class='row'>
                <div class='col-md-4'>
                        <strong>Date: </strong>{{$donation->donation_date->format('m/d/Y')}}
                        <br /><strong>Description: </strong>{{$donation->donation_description}}  
                        <br /><strong>Pledged/Paid: </strong>${{number_format($donation->donation_amount,2)}} / ${{number_format($donation->payments->sum('payment_amount'),2)}}  
                        ({{number_format($donation->percent_paid,0)}}%)
                        <br /><strong>Primary contact: </strong>{{$donation->Notes1}}
                        <br /><strong>Retreat: </strong>{!!$donation->retreat_link!!} ({{$donation->retreat_id}})
                        <br /><strong>Notes: </strong>{{$donation->Notes}}
                        <br /><strong>Terms: </strong>{{$donation->terms}}
                        <br /><strong>Start date: </strong>{{$donation->start_date}}
                        <br /><strong>End date: </strong>{{$donation->end_date}}
                        <br /><strong>Donation install: </strong>{{$donation->donation_install}}
                    
                </div>
            </div>
            <hr />
                
            <div class='row'>
                <div class='col-md-8'>
                    <table class="table table-bordered table-striped table-hover">
                        <caption><h2>Payments for Donation #{{$donation->donation_id}} - Total payments: ${{number_format($donation->payments->sum('payment_amount'),2)}}</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Check or CC#</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($donation->payments as $payment)
                        <tr>

                            <td><a href="../payment/{{ $payment->payment_id}}">{{$payment->payment_date->format('m/d/Y')}}</a></td>
                            <td>${{ $payment->payment_amount }} </td>
                            <td>{{ $payment->payment_description }}</td>
                            <td>{{ $payment->cknumber or $payment->ccnumber }}</td>
                            <td>{{ $payment->note }}
                        </tr>
                        @endforeach
                        
                    </tbody>
                    
                </table>
                
                   
                </div>
            </div>
            <div class='row'>
                @can('update-donation')
                    <div class='col-md-1'>
                        <a href="{{ action('DonationController@edit', $donation->donation_id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
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
