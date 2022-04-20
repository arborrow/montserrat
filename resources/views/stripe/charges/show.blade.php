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
                    <br /><strong>Amount: </strong>${{ number_format($charge->amount/100,2) }}
                    <br /><strong>Description: </strong>{{$charge->description}}
                    <br /><strong>Receipt Email: </strong>{{ isset($charge->receipt_email) ? $charge->receipt_email : 'N/A' }}
                </div>
                    <div class="col-lg-12 table-responsive-lg">


                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th><strong>Name</strong></th>
                                <th><strong>Email</strong></th>
                                <th><strong>Phone</strong></th>
                                <th><strong>Zip</strong></th>
                                <th><strong>Last4</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Billing</strong></td>
                                <td>{{ isset($charge->billing_details->name) ? $charge->billing_details->name  : 'N/A'}} </td>
                                <td>{{ isset($charge->billing_details->email) ? $charge->billing_details->email : 'N/A' }}</td>
                                <td>{{ isset($charge->billing_details->phone) ? $charge->billing_details->phone : 'N/A' }}</td>
                                <td>{{ isset($charge->billing_details->address->postal_code) ? $charge->billing_details->address->postal_code  : 'N/A'}}</td>
                                <td>{{ isset($charge->payment_method_details->card->last4) ? $charge->payment_method_details->card->last4 : 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td><strong>Card</strong></td>
                                <td>{{ isset($charge->card->name) ? $charge->card->name : 'N/A' }} </td>
                                <td></td>
                                <td></td>
                                <td>{{ isset($charge->card->address_zip) ? $charge->card->address_zip : 'N/A' }}</td>
                                <td>{{ isset($charge->card->last4) ? $charge->card->last4 : 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td><strong>Customer</strong></td>
                                <td>{{ isset($customer->name) ? $customer->name : 'N/A' }}</td>
                                <td>{{ isset($customer->email) ? $customer->email : 'N/A' }}</td>
                                <td>{{ isset($customer->phone) ? $customer->phone : 'N/A' }}</td>
                                <td></td>
                                <td></td>
                            </tr>


                            <tr>
                                <td><strong>Source</strong></td>
                                <td>{{ isset($charge->source->name) ? $charge->source->name  : 'N/A'}}</td>
                                <td></td>
                                <td></td>
                                <td>{{ isset($charge->source->address_zip) ? $charge->source->address_zip  : 'N/A'}}</td>
                                <td>{{ isset($charge->source->last4) ? $charge->source->last4 : 'N/A' }}</td>
                            </tr>

                    </table>

                </div>
            </div>

        </div>
    </div>
</section>
@stop
