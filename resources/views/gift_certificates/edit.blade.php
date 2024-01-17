@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit Gift Certificate #{{$gift_certificate->certificate_number}}</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('gift_certificate.update', [$gift_certificate->id]))->acceptsFiles()->open() }}
        {{ html()->hidden('id', $gift_certificate->id) }}

        <div class="form-group">
            <div class="border  border-secondary m-2 p-2">
                <h3 class="text-secondary">Info</h3>
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Purchaser ID:', 'purchaser_id') }} {!!$gift_certificate->purchaser?->contact_link_full_name !!}
                        {{ html()->number('purchaser_id', $gift_certificate->purchaser_id)->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Recipient ID:', 'recipient_id') }} {!!$gift_certificate->recipient?->contact_link_full_name !!}
                        {{ html()->number('recipient_id', $gift_certificate->recipient_id)->class('form-control') }}
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Squarespace Order #:', 'squarespace_order_number') }}
                        {{ html()->number('squarespace_order_number', $gift_certificate->squarespace_order_number)->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Sequential #:', 'sequential_number') }}
                        {{ html()->number('sequential_number', $gift_certificate->sequential_number)->class('form-control') }}
                    </div>
                </div>
            </div>

            <div class="border  border-secondary m-2 p-2">

                <h3 class="text-secondary">Dates</h3>
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Purchased:', 'purchase_date') }}
                        {{ html()->date('purchase_date', $gift_certificate->purchase_date)->class('form-control flatpickr-date-time bg-white')->attribute('autocomplete', 'off') }}
                    </div>

                    <div class="col-lg-3">
                        {{ html()->label('Issued:', 'issue_date') }}
                        {{ html()->date('issue_date', $gift_certificate->issue_date)->class('form-control flatpickr-date-time bg-white')->attribute('autocomplete', 'off') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Expiration:', 'expiration_date') }}
                        {{ html()->date('expiration_date', $gift_certificate->expiration_date)->class('form-control flatpickr-date-time bg-white')->attribute('autocomplete', 'off') }}
                    </div>
                </div>
            </div>

            <div class="border  border-secondary m-2 p-2">
                <h3 class="text-secondary">Funding</h3>
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Funded amount:', 'funded_amount') }}
                        {{ html()->number('funded_amount', $gift_certificate->funded_amount)->class('form-control')->attribute('step', '0.01') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Donation ID:', 'donation_id') }}
                        {{ html()->number('donation_id', $gift_certificate->donation_id)->class('form-control') }}
                    </div>
                    <div class="col-lg-3">
                        {{ html()->label('Participant ID:', 'participant_id') }}
                        {{ html()->number('participant_id', $gift_certificate->participant_id)->class('form-control') }}
                    </div>
                </div>
            </div>

            <div class="border  border-secondary m-2 p-2">
                <h3 class="text-secondary">Notes</h3>
                <div class="row">
                    <div class="col-lg-3">
                        {{ html()->label('Retreat type:', 'retreat_type') }}
                        {{ html()->text('retreat_type', $gift_certificate->retreat_type)->class('form-control') }}
                    </div>
                    <div class="col-lg-6">
                        {{ html()->label('Notes:', 'notes') }}
                        {{ html()->textarea('notes', $gift_certificate->notes)->class('form-control')->rows(1) }}
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
            </div>
        </div>
        {{ html()->form()->close() }}

    </div>
</div>
@stop
