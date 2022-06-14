@extends('template')
@section('content')

<div class="row bg-cover">

    <div class="col-lg-12">
        <h1>
            Process Squarespace Contribution #{{ $ss_contribution->id }}
        </h1>
    </div>

    <div class="col-lg-12">
        <a class="btn btn-light" data-toggle="collapse" href="#collapsedInstructions" role="button" aria-expanded="false" aria-controls="collapsedInstructions">
            Instructions
        </a>
    </div>

    <div class="collapse" id="collapsedInstructions">
        <div class="card card-body">
            <ul>
                <li>Select the desired <strong><u>Donor</u></strong> from the Donor dropdown list.
                <li>Select the desired <strong><u>Retreat</u></strong> from the Retreat dropdown list.
                <li>If the Donor is an existing contact, <strong><u>click</u></strong> on the <i>Retrieve Contact Info</i> button to retrieve respective contact information.
                <li><strong><u>Review</u></strong> provided Contribution information. <strong><u>Correct</u></strong> any typos in the provided information.
                    <strong><u>Remove</u></strong> unwanted Donor information to retain existing contact information.
                <li>When finished, <strong><u>click</u></strong> on the <i>Proceed with Contribution</i> button.
                <li>The Squarespace Contribution will be updated.
                    If needed, a new contact will be created.
                    The provided contact information will be added/updated.
                    A touchpoint for the Donor's donation is created.
                    A Donation is created.
                <li>n.b. The Donation Payment will <strong><u>not</u></strong> be created until it is received via Stripe.
            </ul>
        </div>
    </div>

    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['squarespace.contribution.update', $ss_contribution->id]]) !!}
        {!! Form::hidden('id', $ss_contribution->id) !!}

        <hr>
        <div class="form-group">

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <strong>{!! Form::label('contact_id', 'Donor: ' .$ss_contribution->name) !!}</strong>
                    {!! Form::select('contact_id', $matching_contacts, null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-3 col-md-6">
                    <strong>{!! Form::label('event_id', 'Retreat ID: #'. $ss_contribution->idnumber) !!}</strong>
                        {!! Form::select('event_id', $retreats, (isset($ss_contribution->event_id)) ? $ss_contribution->event_id : $ids['retreat_id'], ['class' => 'form-control']) !!}
                    @if (isset($ss_contribution->retreat_description))
                        {{ $ss_contribution->retreat_description }} {{ $ids['retreat_id'] }}
                    @endIf
                </div>

                <div class="col-lg-3 col-md-6">
                    <strong>
                        {!! Form::label('amount', 'Amount:')  !!}
                    </strong>
                        {!! Form::number('amount', $ss_contribution->amount, ['class' => 'form-control','step'=>'0.01']) !!}
                        {{ optional($ss_contribution->donation)->donation_amount }}
                </div>

                <div class="col-lg-3 col-md-6">
                    <strong>
                        {!! Form::label('donation_description', 'Fund:')  !!}
                    </strong>
                    @if (isset($ss_contribution->offering_type))
                        {{ $ss_contribution->offering_type }}
                    @endIf
                    @if (isset($ss_contribution->fund))
                        {{ $ss_contribution->fund }}
                    @endIf
                    {!! Form::select('donation_description', config('polanco.donation_descriptions'), (isset($ss_contribution->fund)) ? $ss_contribution->fund : $ss_contribution->offering_type, ['class' => 'form-control']) !!}
                    {{ optional($ss_contribution->donation)->donation_description }}
                </div>

                <div class="col-lg-3 col-md-6">
                    <strong>
                        {!! Form::label('comments', 'Comments:')  !!}
                    </strong>
                    {!! Form::text('comments', $ss_contribution->comments, ['class' => 'form-control']) !!}
                </div>

            </div>
            <div class="clearfix"> </div>

            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    @if (!$ss_contribution->is_processed)
                        @if ($ss_contribution->contact_id > 0 )
                        {!! Form::submit('Proceed with Contribution',['class' => 'btn btn-dark']) !!}
                        <a class="btn btn-info" href="{{ action([\App\Http\Controllers\SquarespaceContributionController::class, 'reset'],['contribution'=>$ss_contribution->id]) }}">Reset Contact for Contribution #{{ $ss_contribution->id }}</a>
                    @else
                        {!! Form::submit('Retrieve Contact Info',['class' => 'btn btn-info']) !!}

                        @endif
                    @else
                        <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\SquarespaceContributionController::class, 'index']) }}">Squarespace Contribution #{{ $ss_contribution->id }} has already been processed</a>
                    @endIf
                </div>
            </div>
        </div>
        <hr>

        <table class="table table-bordered table-hover">
            <thead>
                <caption>Information from Squarespace Contribution</caption>
                <tr>
                    <th></th>
                    <th>Donor</th>
                </tr>
            </thead>
            <tbody>

                <tr class='table-secondary'>
                    <td>
                        <strong>Full Name</strong>
                    </td>
                    <td>
                        <strong>
                            {!! Form::text('name', ucwords(strtolower($ss_contribution->name)), ['class' => 'form-control']) !!}
                        </strong>
                        @if (isset(optional($ss_contribution->donor)->id))
                        {!! $ss_contribution->donor->contact_link_full_name !!}
                        @endIf
                    </td>
                </tr>

                <tr>
                    <td><strong>First Name</strong></td>
                    @if (strtolower(trim(substr($ss_contribution->name,0,strpos($ss_contribution->name,' ')))) == strtolower(optional($ss_contribution->donor)->first_name))
                    <td class='table-success'>
                        @else
                    <td class='table-warning'>
                        @endif
                        {!! Form::text('first_name', ucwords(strtolower(trim(substr($ss_contribution->name,0,strpos($ss_contribution->name,' '))))), ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->first_name }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Last Name</strong></td>
                    @if (strtolower(trim(substr($ss_contribution->name,strrpos($ss_contribution->name,' ')))) == strtolower(optional($ss_contribution->donor)->last_name))
                    <td class='table-success'>
                        @else
                    <td class='table-warning'>
                        @endif
                        {!! Form::text('last_name', ucwords(strtolower(trim(substr($ss_contribution->name,strrpos($ss_contribution->name,' '))))), ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->last_name }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Email</strong></td>
                    @if (strtolower(trim($ss_contribution->email)) == strtolower(optional($ss_contribution->donor)->email_primary_text))
                    <td class='table-success'>
                        @else
                    <td class='table-warning'>
                        @endif
                        {!! Form::text('email', trim($ss_contribution->email), ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->email_primary_text }}
                    </td>
                </tr>

                @if (isset($ss_contribution->phone))
                <tr>
                    <td><strong>Phone</strong></td>
                    @if ($ss_contribution->phone_formatted == optional($ss_contribution->donor)->primary_phone_number )
                    <td class='table-success'>
                        @else
                    <td class='table-warning'>
                        @endif
                        {!! Form::text('phone', $ss_contribution->phone, ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->primary_phone_number }}
                    </td>
                </tr>
                @endIf

                <tr>
                    <td><strong>Address Street</strong></td>
                    @if (ucwords(strtolower(trim($ss_contribution->address_street))) == ucwords(strtolower(optional($ss_contribution->donor)->address_primary_street)))
                    <td class='table-success'>
                        @else
                    <td class='table-warning'>
                        @endIf
                        {!! Form::text('address_street', ucwords(strtolower($ss_contribution->address_street)), ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->address_primary_street }}
                    </td>
                </tr>

                @if (isset($ss_contribution->address_supplemental))
                <tr>
                    <td><strong>Address Supplemental</strong></td>
                    @if (trim($ss_contribution->address_supplemental) == optional($ss_contribution->donor)->address_primary_supplemental_address )
                    <td class='table-success'>
                        @else
                    <td class='table-warning'>
                        @endIf
                        {!! Form::text('address_supplemental', $ss_contribution->address_supplemental, ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->address_primary_supplemental_address }}
                </tr>
                @endIf

                <tr>
                    <td><strong>Address City</strong></td>
                    @if (trim(strtolower($ss_contribution->address_city)) == strtolower(optional($ss_contribution->donor)->address_primary_city))
                    <td class="table-success">
                        @else
                    <td class="table-warning">
                        @endif
                        {!! Form::text('address_city', ucwords(strtolower($ss_contribution->address_city)), ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->address_primary_city }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Address State</strong></td>
                    @if ($ids['address_state'] == optional($ss_contribution->donor)->address_primary_state_id && isset($ids['address_state']))
                    <td class="table-success">
                        @else
                    <td class="table-warning">
                        @endIf
                        @if (!isset($ids['address_state']))
                        {{ strtoupper($ss_contribution->address_state)}}
                        @endIf
                        {!! Form::select('address_state_id', $states, $ids['address_state'], ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->address_primary_state }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Address Zip</strong></td>
                    @if (trim($ss_contribution->address_zip == optional($ss_contribution->donor)->address_primary_postal_code))
                    <td class='table-success'>
                        @else
                    <td class='table-warning'>
                        @endIf
                        {!! Form::text('address_zip', $ss_contribution->address_zip, ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->address_primary_postal_code }}
                    </td>
                </tr>

                <tr>
                    <td data-toggle="tooltip" data-placement="top" title="Address Country defaults to US"><strong>Address Country * </strong></td>
                    @if ($ids['address_country'] == optional($ss_contribution->donor)->address_primary_country_id)
                    <td class='table-success'>
                        @else
                    <td class='table-warning'>
                        @endif
                        {!! Form::label('address_country_id', $ss_contribution->address_country) !!}
                        {!! Form::select('address_country_id', $countries, $ids['address_country'], ['class' => 'form-control']) !!}
                        {{ optional($ss_contribution->donor)->address_primary_country_abbreviation }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Amount</strong></td>
                    @if (optional($ss_contribution->donation)->donation_amount == $ss_contribution->amount )
                        <td class='table-success'>
                    @else
                        <td class='table-warning'>
                    @endIf
                        {!! Form::number('amount', $ss_contribution->amount, ['class' => 'form-control','step'=>'0.01']) !!}
                        {{ optional($ss_contribution->donation)->donation_amount }}
                    </td>
                </tr>

            </tbody>
        </table>


        <div class="row text-center mt-3">
            <div class="col-lg-12">
                @if (!$ss_contribution->is_processed)
                    @if ($ss_contribution->contact_id > 0 )
                    {!! Form::submit('Proceed with Contribution',['class' => 'btn btn-dark']) !!}
                    @else
                    {!! Form::submit('Retrieve Contact Info',['class' => 'btn btn-info']) !!}
                    @endif
                @else
                    <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\SquarespaceContributionController::class, 'index']) }}">Squarespace Contribution #{{ $ss_contribution->id }} has already been processed</a>
                @endIf
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                @if ($ss_contribution->contact_id > 0)
                    <strong>Donor:</strong>
                    {!! optional($ss_contribution->donor)->contact_link_full_name !!}
                    <br />
                @endIf
                @if (isset($ss_contribution->event_id))
                    <strong>Retreat:</strong> <a href="{{ URL('/retreat/'.$ss_contribution->event_id) }}">{{ $ss_contribution->event->retreat_name }}</a><br />
                @endIf
                @if (isset($ss_contribution->donation_id))
                    <strong>Donation ID:</strong> <a href="{{ URL('/donation/'.$ss_contribution->donation_id) }}">{{ $ss_contribution->donation_id }}</a><br />
                @endIf
                <strong>Message ID:</strong> <a href="{{URL('/mailgun/'.$ss_contribution->message_id)}}">{{ $ss_contribution->message_id }}</a><br />
                <strong>Processed:</strong> {{ ($ss_contribution->is_processed) ? 'Yes' : 'No' }} <br />
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
