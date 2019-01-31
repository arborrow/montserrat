@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                        Offering Dedup Details for {{$combo}} <br />
                         {!! Html::link(action('SystemController@offeringdedup_index'),'Offering Dedup Index',array('class' => 'btn btn-outline-dark'))!!}
                   
                    </h2> 
                    <br />
                </span>                
            </div>        
            <div class='row'>
                <div class='col-md-6'>
                     <table class="table table-bordered table-striped table-hover table-responsive">
                            <caption><h2>{!! $donations->first()->contact->contact_link!!} attending 
                                    <a href="{{url('event/'.$donations->first()->event_id)}}">{{$donations->first()->retreat_name}}</a> 
                                    paying <u>${{number_format($donations->sum('payments_paid'),2)}}</u>  of pledged <u>${{number_format($donations->sum('donation_amount'),2)}}</u> </h2></caption>
                            <thead>
                                <tr>
                                    <th>Donation</th>
                                    <th>Payments</th>
                                    
                            </thead>
                            <tbody>
                       
                    @foreach($donations as $donation)
                    <tr>
                        <td><strong>Donation ID (Date):</strong> <a href='{{url('donation/'.$donation->donation_id)}}'>{{$donation->donation_id.' ('.$donation->donation_date->format('m/d/Y').')'}}</a>
                        <strong>Pledged/Paid:</strong> ${{number_format($donation->donation_amount,2)}} / ${{number_format($donation->payments_paid,2)}} <br />
                        Notes/Contact: {{$donation->Notes}}/{{$donation->Notes1}} <br />
                        Terms: {{$donation->terms}} <br />
                        Installment: {{$donation->donation_install}} <br />
                        Start/End Dates: {{$donation->donation_start_date}}/{{$donation->donation_end_date}} <br />
                        </td>
                        @if ($donation->payments->count()>0)
                        <td>
                            <ul>
                            @foreach($donation->payments as $payment)
                            <li><a href="{{url('payment/'.$payment->payment_id)}}">{{$payment->payment_id}} ({{$payment->payment_date_formatted}}) </a>  <br />
                                ${{number_format($payment->payment_amount,2)}} by {{$payment->payment_description}} #{{$payment->payment_number}} <br />
                                {{$payment->note}}    
                            
                            @endforeach
                            </ul>
                        </td>
                        @endIf
                    </tr>
                    @endforeach
                    </tbody>
                     </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
