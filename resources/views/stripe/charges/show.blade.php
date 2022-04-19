@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                            Charge details
                    </h2>
                </span>
            </div>

            <div class='row'>
                <div class='col-md-4'>
                    <strong>Charge ID: </strong>{{$charge->id}}
                    <br /><strong>Date: </strong>{{\Carbon\Carbon::parse($charge->created)}}

                    @if (isset($charge->customer))
                        <br /><strong>Customer Name: </strong>{{ isset($customer->name) ? $customer->name : 'N/A' }}
                    @else
                        <br /><strong>Billing Name: </strong>{{ isset($charge->billing_details->name) ? $charge->billing_details->name : 'N/A' }}
                    @endIf

                    @if (isset($charge->customer))
                        <br /><strong>Customer Email: </strong>{{ isset($customer->email) ? $customer->email : 'N/A' }}
                    @else
                        <br /><strong>Billing Email: </strong>{{ isset($charge->billing_details->email) ? $charge->billing_details->email : 'N/A' }}
                    @endIf

                    @if (isset($charge->customer))
                        <br /><strong>Customer Phone: </strong>{{ isset($customer->phone) ? $customer->phone : 'N/A' }}
                    @else
                        <br /><strong>Billing Email: </strong>{{ isset($charge->billing_details->phone) ? $charge->billing_details->phone : 'N/A' }}
                    @endIf

                    <br /><strong>Amount: </strong>${{ number_format($charge->amount/100,2) }}
                    <br /><strong>Description: </strong>{{$charge->description}}

                </div>
            </div>

        </div>
    </div>
</section>
@stop
