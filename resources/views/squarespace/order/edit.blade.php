@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Process SquareSpace Order #{{ $order->order_number }} ({{ $order->retreat_category }})
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
                    <li>Select the desired <strong><u>Retreatant(s)</u></strong> from the Retreatant/Couple dropdown list(s).
                    <li>Select the desired <strong><u>Retreat</u></strong> from the Retreat dropdown list.
                    <li>If the retreatant(s) is/are existing contact(s), <strong><u>click</u></strong> on the <i>Retrieve Contact Info</i> button to retrieve respective contact information.
                    <li><strong><u>Review</u></strong> provided Order information.  <strong><u>Correct</u></strong> any typos in the provided information.
                        <strong><u>Remove</u></strong> unwanted Order information to retain existing contact information.
                    <li>When finished, <strong><u>click</u></strong> on the <i>Proceed with Order</i> button.
                    <li>The order will be updated.
                        If needed, a new contact will be created.
                        The provided contact information will be added/updated.
                        A touchpoint for the retreatant's registration is created.
                        A retreat registration is created.
                    <li>Finally, remember to <strong><u>Fulfill the SquareSpace Order</u></strong>.
                </ul>
            </div>
        </div>

    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['squarespace.order.update', $order->id]]) !!}
        {!! Form::hidden('id', $order->id) !!}
        <hr>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('contact_id', 'Retreatant: ' .$order->name) !!}</h3>
                    {!! Form::select('contact_id', $matching_contacts, (isset($order->contact_id)) ? $order->contact_id : null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('event_id', 'Retreat Id#: '. $order->retreat_idnumber) !!}</h3>
                    {!! Form::select('event_id', $retreats, (isset($order->event_id)) ? $order->event_id : null, ['class' => 'form-control']) !!}
                    <strong>Retreat:</strong> {{ $order->retreat_description  }}<br />
                    <strong>Dates:</strong> {{ $order->retreat_dates}}<br />
                    <strong>Type:</strong> {{ $order->retreat_registration_type }}<br />
                </div>
                <div class="col-lg-4 col-md-6">
                    @if (isset($order->gift_certificate_number))
                    <h3>{!! Form::label('gift_certificate_number', 'Gift Certificate #:') !!}</h3>
                    {!! Form::text('gift_certificate_number', $order->gift_certificate_number, ['class' => 'form-control']) !!}
                    @endif
                    @if (isset($order->gift_certificate_retreat))
                    {!! Form::label('gift_certificate_retreat', 'Retreat: '.$order->gift_certificate_retreat) !!}
                    {!! Form::select('gift_certificate_retreat', $retreats, null, ['class' => 'form-control']) !!}
                    <hr>
                    @endif
                    @if (isset($order->comments))
                    <h3>{!! Form::label('comments', 'Comments: ') !!}</h3>
                    {!! Form::text('comments', $order->comments, ['class' => 'form-control']) !!}
                    @endIf
                    @if (isset($order->additional_names_and_phone_numbers))
                    <h3>Other names and phone numbers:</h3> {{ $order->additional_names_and_phone_numbers }}
                    @endIf
                </div>
            </div>

            @if ($order->is_couple)
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('couple_contact_id', 'Couple: ' .$order->couple_name) !!}</h3>
                    {!! Form::select('couple_contact_id', $couple_matching_contacts, (isset($order->couple_contact_id)) ? $order->couple_contact_id : null, ['class' => 'form-control']) !!}
                </div>
            </div>
            @endIf
            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    @if (isset($order->contact_id))
                        {!! Form::submit('Proceed with Order',['class' => 'btn btn-dark']) !!}
                    @else
                        {!! Form::submit('Retrieve Contact Info',['class' => 'btn btn-info']) !!}
                    @endif
                </div>

            </div>
            <hr>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <caption>Information from SquareSpace Order</caption>
                    <tr>
                        <th></th>
                        <th>Retreatant</th>
                        @if ($order->is_couple)
                        <th>Couple</th>
                        @endIf
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Title</strong></td>
                        @if ($ids['title'] == optional($order->retreatant)->prefix_id )
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endIf
                            {!! Form::select('title', $prefixes, $ids['title'], ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->prefix_name }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::select('couple_title', $prefixes, $ids['couple_title'], ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->prefix_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td><strong>Full Name</strong></td>
                        <td>
                            <h3>{{ $order->name }}</h3><br>
                            {{ optional($order->retreatant)->full_name }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            <h3>{{ $order->couple_name  }}</h3><br>
                            {{ optional($order->couple)->full_name }}
                        </td>
                        @endIf
                    </tr>
                    <tr>
                        <td><strong>First Name</strong></td>
                        @if (trim(substr($order->name,0,strpos($order->name,' '))) == optional($order->retreatant)->first_name)
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endif
                            {!! Form::text('first_name', trim(substr($order->name,0,strpos($order->name,' '))), ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->first_name }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_first_name', trim(substr($order->couple_name,0,strpos($order->couple_name,' '))), ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->first_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td data-toggle="tooltip" data-placement="top" title="Middle Name field defaults to empty">
                            <strong>Middle Name * </strong>
                        </td>
                        <td>
                            {!! Form::text('middle_name', null, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->middle_name }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_middle_name', null, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->middle_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td><strong>Last Name</strong></td>
                        @if (trim(substr($order->name,strrpos($order->name,' '))) == optional($order->retreatant)->last_name)
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endif
                            {!! Form::text('last_name', trim(substr($order->name,strrpos($order->name,' '))), ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->last_name }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_last_name', trim(substr($order->couple_name,strpos($order->couple_name,' '))), ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->last_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td data-toggle="tooltip" data-placement="top" title="Nickname field defaults to empty">
                            <strong>Nickname *</strong>
                        </td>
                        <td>
                            {!! Form::text('nick_name', null, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->nick_name }}<br>
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_nick_name', null, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->nick_name }}<br>
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td><strong>Email</strong></td>
                        @if (trim($order->email) == optional($order->retreatant)->email_primary_text)
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endif
                            {!! Form::text('email', trim($order->email), ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->email_primary_text }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_email', $order->couple_email, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->email_primary_text }}
                        </td>
                        @endIf
                    </tr>
                    <tr>
                        <td><strong>Mobile Phone</strong></td>
                        <td>
                            {!! Form::text('mobile_phone', $order->mobile_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->phone_home_mobile_number }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_mobile_phone', $order->couple_mobile_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->phone_home_mobile_number }}
                        </td>
                        @endIf
                    </tr>
                    @if (isset($order->home_phone))
                    <tr>
                        <td><strong>Home Phone</strong></td>
                        <td>
                            {!! Form::text('home_phone', $order->home_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->phone_home_phone_number }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endif
                    @if (isset($order->home_phone))
                    <tr>
                        <td><strong>Work Phone</strong></td>
                        <td>
                            {!! Form::text('work_phone', $order->work_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->phone_work_phone_number }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address (Full)</strong></td>
                        <td><strong>{{ $order->full_address }}</strong></td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endif
                    @if (isset($order->address_street))
                    <tr>
                        <td><strong>Address Street</strong></td>
                        @if (trim($order->address_street) == optional($order->retreatant)->address_primary_street )
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endIf
                            {!! Form::text('address_street', $order->address_street, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_street }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->address_supplemental))
                    <tr>
                        <td><strong>Address Supplemental</strong></td>
                        @if (trim($order->$order->address_supplemental) == optional($order->retreatant)->address_primary_supplemental )
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endIf
                            {!! Form::text('address_supplemental', $order->address_supplemental, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_supplemental }}
                            @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->address_city))
                    <tr>
                        <td><strong>Address City</strong></td>
                        @if (trim($order->address_city) == optional($order->retreatant)->address_primary_city )
                            <td class="table-success">
                        @else
                            <td class="table-warning">
                        @endif
                            {!! Form::text('address_city', $order->address_city, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_city }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->address_state))
                    <tr>
                        <td><strong>Address State</strong></td>
                        @if ($ids['address_state'] == optional($order->retreatant)->address_primary_state_id )
                            <td class="table-success">
                        @else
                            <td class="table-warning">
                        @endIf
                            {!! Form::select('address_state', $states, $ids['address_state'], ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_state }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->address_zip))
                    <tr>
                        <td><strong>Address Zip</strong></td>
                        @if (trim($order->address_zip == optional($order->retreatant)->address_primary_postal_code))
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endIf
                            {!! Form::text('address_zip', $order->address_zip, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_postal_code }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->address_country))
                    <tr>
                        <td data-toggle="tooltip" data-placement="top" title="Address Country defaults to US"><strong>Address Country * </strong></td>
                        @if ($ids['address_country'] == optional($order->retreatant)->address_primary_country_id)
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endif
                            {!! Form::label('address_country', $order->address_country) !!}
                            {!! Form::select('address_country', $countries, $ids['address_country'], ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_country_abbreviation }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->dietary))
                    <tr>
                        <td><strong>Dietary</strong></td>
                        <td>
                            {!! Form::text('dietary', $order->dietary, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->note_dietary_text }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_dietary', $order->couple_dietary, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->note_dietary_text }}
                        </td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->date_of_birth) || isset($order->couple_date_of_birth))
                    <tr>
                        <td><strong>Date of Birth</strong></td>
                        <td>
                            {!! Form::text('date_of_birth', $order->date_of_birth, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                            {{ (isset(optional($order->retreatant)->birth_date)) ? date('F d, Y', strtotime(optional($order->retreatant)->birth_date)) : null }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('date_of birth', $order->couple_date_of_birth, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                            {{ (isset(optional($order->couple)->birth_date)) ? date('F d, Y', strtotime(optional($order->couple)->birth_date)) : null }}
                        </td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->room_preference))
                    <tr>
                        <td><strong>Room Preference</strong></td>
                        <td>
                            {!! Form::text('room_preference', ($order->room_preference == 'Ninguna' || $order->room_preference == 'None') ? null : $order->room_preference, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->note_room_preference_text }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->preferred_language))
                    <tr>
                        <td><strong>Preferred Language</strong></td>
                        <td>
                            {!! Form::label('preferred_language', isset($order->preferred_language) ? $order->preferred_language : 'N/A' ) !!}
                            {!! Form::select('preferred_language', $languages, $ids['preferred_language'], ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->preferred_language_label }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->parish))
                    <tr>
                        <td  data-toggle="tooltip" data-placement="top" title="Parish dropdown defaults to none because of complexity of matching parish names">
                            <strong>Parish *</strong>
                        </td>
                        <td>
                            {!! Form::label('parish', ucwords(strtolower($order->parish))) !!}
                            {!! Form::hidden('parish', ucwords(strtolower($order->parish))) !!}
                            {!! Form::select('parish_id', $parish_list, null, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->parish_name }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->emergency_contact) || isset($order->couple_emergency_contact))
                    <tr>
                        <td><strong>Emergency Contact</strong></td>
                        <td>
                            {!! Form::text('emergency_contact', $order->emergency_contact, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->emergency_contact_name }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_emergency_contact', $order->couple_emergency_contact, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->emergency_contact_name }}
                        </td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->emergency_contact_relationship) || isset($order->couple_emergency_contact_relationship))
                    <tr>
                        <td><strong>Emergency Contact Relationship</strong></td>
                        <td>
                            {!! Form::text('emergency_contact_relationship', $order->emergency_contact_relationship, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->emergency_contact_relationship }}
                            @if ($order->is_couple)
                        <td>
                            {!! Form::text('couple_emergency_contact_relationship', $order->couple_emergency_contact_relationship, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->emergency_contact_relationship }}
                        </td>
                        @endIf
                    </tr>
                    @endIf
                    @if (isset($order->emergency_contact_phone) || isset($order->couple_emergency_contact_phone))
                        <tr>
                            <td><strong>Emergency Contact Phone</strong></td>
                            <td>
                                {!! Form::text('emergency_contact_phone', $order->emergency_contact_phone, ['class' => 'form-control']) !!}
                                {{ optional($order->retreatant)->emergency_contact_phone }}
                            </td>
                            @if ($order->is_couple)
                            <td>
                                {!! Form::text('couple_emergency_contact_phone', $order->couple_emergency_contact_phone, ['class' => 'form-control']) !!}
                                {{ optional($order->couple)->emergency_contact_phone }}
                            </td>
                            @endIf
                        </tr>
                    @endIf
                    @if (isset($order->deposit_amount))
                        <tr>
                            <td><strong>Deposit</strong></td>
                            <td>
                                {!! Form::number('deposit_amount', $order->deposit_amount, ['class' => 'form-control','step'=>'0.01']) !!}
                            </td>
                            @if ($order->is_couple)
                            <td>
                            </td>
                            @endIf
                        </tr>
                    @endIf
                    @if (isset($order->order_number))
                        <tr>
                            <td><strong>Order #</strong></td>
                            <td>
                                {!! Form::text('order_number', $order->order_number, ['class' => 'form-control']) !!}
                            </td>
                            @if ($order->is_couple)
                            <td>
                            </td>
                            @endIf
                        </tr>
                    @endIf
                </tbody>
            </table>
            <hr>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <strong>Message ID:</strong> <a href="{{URL('/mailgun/'.$order->message_id)}}">{{ $order->message_id }}</a><br />
                    <strong>Processed:</strong> {{ ($order->is_processed) ? 'Yes' : 'No' }} <br />
                    @if (isset($order->event_id))
                    <strong>Event ID:</strong> <a href="{{ URL('/retreat/'.$order->event_id) }}">{{ $order->event->retreat_name }}</a><br />
                    @endIf
                    @if (isset($order->participant_id))
                    <strong>Registration ID:</strong> <a href="{{ URL('/registration/'.$order->participant_id) }}">{{ $order->participant_id }}</a><br />
                    @endIf
                </div>
            </div>

        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop
