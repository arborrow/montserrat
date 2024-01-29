@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit Donation ID#: {{ $donation->donation_id }} for {!! $donation->contact->contact_link_full_name ?? 'Unknown contact' !!}</h1>
    </div>
    <div class="col-lg-12">
        <h2>Donation details</h2>
        {{ html()->form('PUT', route('donation.update', [$donation->donation_id]))->open() }}
        {{ html()->hidden('donation_id', $donation->donation_id) }}
        {{ html()->hidden('donor_id', $donation->contact_id) }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Description', 'donation_description') }}
                        {{ html()->select('donation_description', $descriptions, $donation->donation_description)->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Retreat', 'event_id') }}
                        @if (isset($defaults['event_id']))
                            {{ html()->select('event_id', $retreats, $defaults['event_id'])->class('form-control') }}
                        @else
                            {{ html()->select('event_id', $retreats, $donation->event_id)->class('form-control') }}
                        @endif
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Date', 'donation_date') }}
                        {{ html()->date('donation_date', $donation->donation_date)->class('form-control flatpickr-date') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Amount', 'donation_amount') }}
                        {{ html()->number('donation_amount', $donation->donation_amount)->class('form-control')->attribute('step', '0.01') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Primary contact for invoice', 'notes1') }}
                        {{ html()->text('notes1', $donation->Notes1)->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Notes', 'notes') }}
                        {{ html()->text('notes', $donation->Notes)->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4">
                      {{ html()->label('Thank you letter', 'donation_thank_you') }}
                      {{ html()->select('donation_thank_you', ['Y' => 'Yes', 'N' => 'No'], $donation->donation_thank_you_sent)->class('form-control') }}
                  </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Start date', 'start_date') }}
                        {{ html()->date('start_date', $donation->start_date)->class('form-control flatpickr-date') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('End date', 'end_date') }}
                        {{ html()->date('end_date', $donation->end_date)->class('form-control flatpickr-date') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Installment', 'donation_install') }}
                        {{ html()->number('donation_install', $donation->donation_install)->class('form-control')->attribute('step', '0.01') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Terms', 'terms') }}
                        {{ html()->text('terms', $donation->terms)->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Stripe Invoice #', 'stripe_invoice') }}
                        {{ html()->text('stripe_invoice', $donation->stripe_invoice)->class('form-control') }}
                    </div>

                </div>
                <div class="row text-center mt-4">
                    <div class="col-lg-12">
                        {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                    </div>
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop
