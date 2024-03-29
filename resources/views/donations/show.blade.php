@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            @can('update-donation')
                <a href="{{url('donation/'.$donation->donation_id.'/edit')}}">Donation details</a>
            @else
                Donation details
            @endCan
            for {!!$donation->contact->contact_link_full_name!!}
        </h1>
        {{ html()->a(url(action([\App\Http\Controllers\PageController::class, 'finance_invoice'], $donation->donation_id)), 'Invoice')->class('m-1 btn btn-outline-dark') }}
        @can('create-payment')
            <a href={{ url('payment/create/'.$donation->donation_id) }} class="m-1 btn btn-outline-dark">Add payment</a>
        @endCan
        @if (in_array($donation->donation_description, config('polanco.agc_donation_descriptions')) )
            @if(isset($donation['Thank You']))
                {{ html()->a(url(action([\App\Http\Controllers\PageController::class, 'finance_agc_acknowledge'], $donation->donation_id)), "Reprint AGC acknowledgement")->class('m-1 btn btn-outline-dark') }}
            @else
                @if ($donation->percent_paid >= 100)
                    {{ html()->a(url(action([\App\Http\Controllers\PageController::class, 'finance_agc_acknowledge'], $donation->donation_id)), "Print AGC acknowledgement")->class('m-1 btn btn-outline-dark') }}
                @else
                    <div class="m-1 btn btn-outline-dark disabled" aria-disabled="true">AGC awaiting full payment</div>
                @endIf
            @endIf

        @endIf
    </div>
    <div class="col-lg-4 col-md-6">
        <span class="font-weight-bold">Date: </span>{{$donation->donation_date->format('m/d/Y')}}
        <br><span class="font-weight-bold">Description: </span>{{$donation->donation_description}}
        <br>
            @if (number_format($donation->donation_amount - $donation->payments->sum('payment_amount'),2,'.','') >= 0.01)
              <span class="font-weight-bold alert alert-warning alert-important" style="padding:0px;">
            @endIf
            @if (number_format($donation->donation_amount - $donation->payments->sum('payment_amount'),2,'.','') <= -0.01)
              <span class="font-weight-bold alert alert-danger alert-important" style="padding:0px;">
            @endIf
            @if (number_format(($donation->donation_amount - $donation->payments->sum('payment_amount')),2,'.','') == 0.00)
              <span class="font-weight-bold">
            @endIf
          Paid/Pledged:  ${{number_format($donation->payments->sum('payment_amount'),2)}} / ${{number_format($donation->donation_amount,2)}}
          ({{$donation->percent_paid}}%)</span>

        <br><span class="font-weight-bold">Primary contact: </span>{{$donation->Notes1}}
    </div>
    <div class="col-lg-4 col-md-6">
        <span class="font-weight-bold">Event: </span>{!!$donation->retreat_link!!} ({{$donation->retreat_start_date}})
        <br><span class="font-weight-bold">Notes: </span>{{$donation->Notes}}
        <br><span class="font-weight-bold">Thank you sent: </span>{{$donation['Thank You']}}
    </div>
    <div class="col-lg-4 col-md-6">
      <span class="font-weight-bold">Start date: </span>{{$donation->start_date}}
      <br><span class="font-weight-bold">End date: </span>{{$donation->end_date}}
      <br><span class="font-weight-bold">Donation install: </span>{{$donation->donation_install}}
      <br><span class="font-weight-bold">Terms: </span>{{$donation->terms}}
      <br><span class="font-weight-bold">Stripe Invoice #: </span>{{$donation->stripe_invoice}}
    </div>
    <div class="col-lg-12 mt-3">
        <table class="table table-bordered table-striped table-hover table-responsive-md">
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
                    <td><a href="../payment/{{ $payment->payment_id}}">{{$payment->payment_date_formatted}}</a></td>
                    <td>${{ $payment->payment_amount }} </td>
                    <td>
                        @if (isset($payment->balance_transaction->id))
                            @can('show-stripe-balance-transaction')
                                <a href="{{url('stripe/balance_transaction/'.$payment->balance_transaction->balance_transaction_id)}}">{{$payment->payment_description}}</a>
                            @else 
                                {{ $payment->payment_description }}
                            @endCan
                        @else
                            {{ $payment->payment_description }}
                        @endIf
                    </td>
                    <td>{{ $payment->cknumber ?? $payment->ccnumber }}</td>
                    <td>{{ $payment->note }}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-donation')
                    <a href="{{ action([\App\Http\Controllers\DonationController::class, 'edit'], $donation->donation_id) }}" class="m-1 btn btn-info">{{ html()->img(asset('images/edit.png'), 'Edit')->attribute('title', "Edit") }}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-donation')
                    {{ html()->form('DELETE', route('donation.destroy', [$donation->donation_id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('m-1 btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                    {{ html()->form()->close() }}
                @endCan
            </div>
        </div>
    </div>
</div>
@stop
