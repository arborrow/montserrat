@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Process Squarespace Order #{{ $order->order_number }}
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
                <li><strong><u>Review</u></strong> provided Order information. <strong><u>Correct</u></strong> any typos in the provided information.
                    <strong><u>Remove</u></strong> unwanted Order information to retain existing contact information.
                <li>When finished, <strong><u>click</u></strong> on the <i>Proceed with Order</i> button.
                <li>The Squarespace Order will be updated.
                    If needed, a new contact will be created.
                    The provided contact information will be added/updated.
                    A touchpoint for the retreatant's registration is created.
                    A retreat registration is created.
                <li>Finally, remember to <strong><u>Fulfill the Squarespace Order</u></strong>.
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
                    {!! Form::select('contact_id', $matching_contacts, (isset($order->contact_id)) ? $order->contact_id : 0, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('event_id', 'Retreat Id#: '. $order->retreat_idnumber) !!}</h3>
                    {!! Form::select('event_id', $retreats, (isset($order->event_id)) ? $order->event_id : $ids['retreat_id'], ['class' => 'form-control']) !!}
                    <strong>Retreat:</strong> {{ $order->retreat_description  }}<br />
                    <strong>Dates:</strong> {{ $order->retreat_dates}}<br />
                    <strong>Category:</strong> {{ $order->retreat_category  }}<br />
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
                    <h3>
                        {!! Form::label('comments', 'Comments: ') !!}
                    </h3>
                    {!! Form::text('comments', $order->comments, ['class' => 'form-control']) !!}
                    @endIf
                    @if (isset($order->retreat_quantity) && $order->retreat_quantity > 1)
                    <div class='table-danger' data-toggle="tooltip" data-placement="top" title="Quantities greater than 1 need to be manually processed">
                        <h3>{!! Form::label('retreat_quantity', 'Quantity: ') !!} *</h3>
                        {!! Form::number('retreat_quantity', $order->retreat_quantity, ['class' => 'form-control','step'=>'1']) !!}
                    </div>
                    @endIf
                    @if (isset($order->additional_names_and_phone_numbers))
                    <div class='table-danger' data-toggle="tooltip" data-placement="top" title="Additional names will need to be manually processed">
                        <h3>Additional Names and Phone Numbers *: </h3>
                        {!! Form::text('additional_names_and_phone_numbers', $order->additional_names_and_phone_numbers, ['class' => 'form-control']) !!}
                    </div>
                    @endIf
                </div>
            </div>

            @if ($order->is_couple)
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('couple_contact_id', 'Couple: ' .$order->couple_name) !!}</h3>
                    {!! Form::select('couple_contact_id', $couple_matching_contacts, (isset($order->couple_contact_id)) ? $order->couple_contact_id : 0, ['class' => 'form-control']) !!}
                </div>
            </div>
            @endIf

            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    @if (!$order->is_processed)
                        @if (($order->contact_id > 0 && !$order->is_couple) || (($order->is_couple) && $order->couple_contact_id > 0 && $order->contact_id>0))
                        {!! Form::submit('Proceed with Order',['class' => 'btn btn-dark']) !!}
                        <a class="btn btn-info" href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'reset'],['order'=>$order->id]) }}">Reset Contact for Order #{{ $order->id }}</a>
                        @else
                        {!! Form::submit('Retrieve Contact Info',['class' => 'btn btn-info']) !!}
                        @endif
                    @else
                        <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'index']) }}">Order #{{ $order->order_number }} has already been processed</a>
                    @endIf
                </div>
            </div>

            <hr>
            <table class="table table-bordered table-hover">
                <thead>
                    <caption>Information from Squarespace Order</caption>
                    <tr>
                        <th></th>
                        <th>Retreatant</th>
                        @if ($order->is_couple)
                        <th>Couple</th>
                        @endIf
                    </tr>
                </thead>
                <tbody>

                    <tr class='table-secondary'>
                        <td>
                            <strong>Full Name</strong>
                        </td>
                        <td>
                            <h3>
                                {!! Form::text('name', ucwords(strtolower($order->name)), ['class' => 'form-control']) !!}
                            </h3>
                            @if (isset(optional($order->retreatant)->id))
                            {!! $order->retreatant->contact_link_full_name !!}
                            @endIf
                            <div class="row">
                                <div class='col-3'>
                                    <a class="btn btn-secondary" data-toggle="collapse" href="#collapsedMiddleName" role="button" aria-expanded="false" aria-controls="collapsedMiddleName">
                                        Show Middle Name
                                    </a>
                                </div>
                                <div class='col-3'>
                                    <a class="btn btn-secondary" data-toggle="collapse" href="#collapsedNickName" role="button" aria-expanded="false" aria-controls="collapsedNickName">
                                        Show Nickname
                                    </a>
                                </div>
                                <div class='col-3'>
                                    <a class="btn btn-secondary" data-toggle="collapse" href="#collapsedHealth" role="button" aria-expanded="false" aria-controls="collapsedHealth">
                                        Show Health Notes
                                    </a>
                                </div>

                            </div>

                        </td>
                        @if ($order->is_couple)
                        <td>
                            <h3>
                                {!! Form::text('couple_name', ucwords(strtolower($order->couple_name)), ['class' => 'form-control']) !!}
                            </h3><br>
                            @if (isset(optional($order->couple)->id))
                            {!! $order->couple->contact_link_full_name !!}
                            @endIf
                        </td>
                        @endIf
                    </tr>
                    <tr>
                        <td><strong>Title</strong></td>
                        @if ($ids['title'] == optional($order->retreatant)->prefix_id)
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::select('title_id', $prefixes, $ids['title'], ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->prefix_name }}
                        </td>
                        @if ($order->is_couple)
                        @if ($ids['couple_title'] == optional($order->couple)->prefix_id)
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::select('couple_title_id', $prefixes, $ids['couple_title'], ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->prefix_name }}
                        </td>
                        @endIf
                    </tr>
                    <tr>
                        <td><strong>First Name</strong></td>
                        @if (strtolower(trim(substr($order->name,0,strpos($order->name,' ')))) == strtolower(optional($order->retreatant)->first_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('first_name', ucwords(strtolower(trim(substr($order->name,0,strpos($order->name,' '))))), ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->first_name }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower(trim(substr($order->couple_name,0,strpos($order->couple_name,' ')))) == strtolower(optional($order->couple)->first_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('couple_first_name', ucwords(strtolower(trim(substr($order->couple_name,0,strpos($order->couple_name,' '))))), ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->first_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr class="collapse" id="collapsedMiddleName">
                        <td data-toggle="tooltip" data-placement="top" title="Middle Name field defaults to empty">
                            <strong>Middle Name * </strong>
                        </td>
                        <td class='table-info'>
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
                        @if (strtolower(trim(substr($order->name,strrpos($order->name,' ')))) == strtolower(optional($order->retreatant)->last_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('last_name', ucwords(strtolower(trim(substr($order->name,strrpos($order->name,' '))))), ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->last_name }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower(trim(substr($order->couple_name,strrpos($order->couple_name,' ')))) == strtolower(optional($order->couple)->last_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('couple_last_name', ucwords(strtolower(trim(substr($order->couple_name,strpos($order->couple_name,' '))))), ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->last_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr class="collapse" id="collapsedNickName">
                        <td data-toggle="tooltip" data-placement="top" title="Nickname field defaults to empty">
                            <strong>Nickname *</strong>
                        </td>
                        <td class='table-info'>
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
                        @if (strtolower(trim($order->email)) == strtolower(optional($order->retreatant)->email_primary_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('email', trim($order->email), ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->email_primary_text }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower(trim($order->couple_email)) == strtolower(optional($order->couple)->email_primary_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('couple_email', $order->couple_email, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->email_primary_text }}
                        </td>
                        @endIf
                    </tr>

                    @if (isset($order->mobile_phone))
                    <tr>
                        <td><strong>Mobile Phone</strong></td>
                        @if ($order->mobile_phone_formatted == optional($order->retreatant)->phone_home_mobile_number )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('mobile_phone', $order->mobile_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->phone_home_mobile_number }}
                        </td>
                        @if ($order->is_couple)
                        @if ($order->couple_mobile_phone_formatted == optional($order->couple)->phone_home_mobile_number )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('couple_mobile_phone', $order->couple_mobile_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->phone_home_mobile_number }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->home_phone))
                    <tr>
                        <td><strong>Home Phone</strong></td>
                        @if ($order->home_phone_formatted == optional($order->retreatant)->phone_home_phone_number )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('home_phone', $order->home_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->phone_home_phone_number }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endif

                    @if (isset($order->work_phone))
                    <tr>
                        <td><strong>Work Phone</strong></td>
                        @if ($order->work_phone_formatted == optional($order->retreatant)->phone_work_phone_number )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::text('work_phone', $order->work_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->phone_work_phone_number }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
                    <tr class='table-secondary'>
                        <td><strong>Address (Full)</strong></td>
                        <td>
                            <strong>
                                {{ ucwords(strtolower($order->full_address)) }}
                            </strong>
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endif

                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address Street</strong></td>
                        @if (ucwords(strtolower(trim($order->address_street))) == ucwords(strtolower(optional($order->retreatant)->address_primary_street)))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('address_street', ucwords(strtolower($order->address_street)), ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_street }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address Supplemental</strong></td>
                        @if (trim($order->address_supplemental) == optional($order->retreatant)->address_primary_supplemental )
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

                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address City</strong></td>
                        @if (trim(strtolower($order->address_city)) == strtolower(optional($order->retreatant)->address_primary_city))
                        <td class="table-success">
                            @else
                        <td class="table-warning">
                            @endif
                            {!! Form::text('address_city', ucwords(strtolower($order->address_city)), ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_city }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address State</strong></td>
                        @if ($ids['address_state'] == optional($order->retreatant)->address_primary_state_id && isset($ids['address_state']))
                        <td class="table-success">
                            @else
                        <td class="table-warning">
                            @endIf
                            @if (!isset($ids['address_state']))
                            {{ strtoupper($order->address_state)}}
                            @endIf
                            {!! Form::select('address_state_id', $states, $ids['address_state'], ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->address_primary_state }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
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

                    @if (isset($order->full_address))
                    <tr>
                        <td data-toggle="tooltip" data-placement="top" title="Address Country defaults to US"><strong>Address Country * </strong></td>
                        @if ($ids['address_country'] == optional($order->retreatant)->address_primary_country_id)
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {!! Form::label('address_country_id', $order->address_country) !!}
                            {!! Form::select('address_country_id', $countries, $ids['address_country'], ['class' => 'form-control']) !!}
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
                        @if (strtolower($order->dietary) == strtolower(optional($order->retreatant)->note_dietary_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('dietary', $order->dietary, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->note_dietary_text }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower($order->couple_dietary) == strtolower(optional($order->couple)->note_dietary_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('couple_dietary', $order->couple_dietary, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->note_dietary_text }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    <tr class="collapse" id="collapsedHealth">
                        <td><strong>Health Note</strong></td>
                        <td class='table-warning'>
                            {!! Form::text('health', null, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->note_health_text }}
                        </td>
                        @if ($order->is_couple)
                        <td class='table-warning'>
                            {!! Form::text('couple_health', null, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->note_health_text }}
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td><strong>Gender</strong></td>
                        <td class='table-warning'>
                            {!! Form::select('gender_id', $genders, null, ['class' => 'form-control']) !!}
                        </td>
                        @if ($order->is_couple)
                            <td class='table-warning'>
                                {!! Form::select('couple_gender_id', $genders, null, ['class' => 'form-control']) !!}
                            </td>
                        @endIf
                    </tr>    

                    @if (isset($order->date_of_birth) || isset($order->couple_date_of_birth))
                    <tr>
                        <td><strong>Date of Birth</strong></td>
                        @if (\Carbon\Carbon::parse($order->date_of_birth) == \Carbon\Carbon::parse(optional($order->retreatant)->birth_date))
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endIf
                            {!! Form::text('date_of_birth', $order->date_of_birth, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                            {{ (isset(optional($order->retreatant)->birth_date)) ? date('F d, Y', strtotime(optional($order->retreatant)->birth_date)) : null }}
                        </td>
                        @if ($order->is_couple)
                        @if (\Carbon\Carbon::parse($order->couple_date_of_birth) == \Carbon\Carbon::parse(optional($order->couple)->birth_date))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('couple_date_of birth', $order->couple_date_of_birth, ['class'=>'form-control flatpickr-date', 'autocomplete'=> 'off']) !!}
                            {{ (isset(optional($order->couple)->birth_date)) ? date('F d, Y', strtotime(optional($order->couple)->birth_date)) : null }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    <tr>
                        <td><strong>Religion</strong></td>
                        <td class='table-warning'>
                            {!! Form::select('religion_id', $religions, null, ['class' => 'form-control']) !!}
                        </td>
                        @if ($order->is_couple)
                            <td class='table-warning'>
                                {!! Form::select('couple_religion_id', $religions, null, ['class' => 'form-control']) !!}
                            </td>
                        @endIf
                    </tr>    



                    @if (!($order->room_preference == 'Ninguna' || $order->room_preference == 'No preference' || null == $order->room_preference))
                    <tr>
                        <td><strong>Room Preference</strong></td>
                        @if (strtolower($order->room_preference) == strtolower(optional($order->retreatant)->note_room_preference_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
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
                            {!! Form::label('preferred_language_id', isset($order->preferred_language) ? $order->preferred_language : 'N/A' ) !!}
                            {!! Form::select('preferred_language_id', $languages, $ids['preferred_language'], ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->preferred_language_label }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->parish))
                    <tr>
                        <td data-toggle="tooltip" data-placement="top" title="Parish dropdown defaults to none because of complexity of matching parish names">
                            <strong>Parish *</strong>
                        </td>
                        <td>
                            {!! Form::label('parish', ucwords(strtolower($order->parish))) !!}
                            {!! Form::hidden('parish', ucwords(strtolower($order->parish))) !!}
                            {!! Form::select('parish_id', $parish_list, (null !== optional($order->retreatant)->parish_id) ? optional($order->retreatant)->parish_id : null, ['class' => 'form-control']) !!}
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
                        @if (strtolower($order->emergency_contact) == strtolower(optional($order->retreatant)->emergency_contact_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('emergency_contact', $order->emergency_contact, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->emergency_contact_name }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower($order->couple_emergency_contact) == strtolower(optional($order->couple)->emergency_contact_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('couple_emergency_contact', $order->couple_emergency_contact, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->emergency_contact_name }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->emergency_contact_relationship) || isset($order->couple_emergency_contact_relationship))
                    <tr>
                        <td>
                            <strong>Emergency Contact Relationship</strong>
                        </td>
                        @if (strtolower($order->emergency_contact_relationship) == strtolower(optional($order->retreatant)->emergency_contact_relationship))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('emergency_contact_relationship', $order->emergency_contact_relationship, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->emergency_contact_relationship }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower($order->couple_emergency_contact_relationship) == strtolower(optional($order->couple)->emergency_contact_relationship))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('couple_emergency_contact_relationship', $order->couple_emergency_contact_relationship, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->emergency_contact_relationship }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->emergency_contact_phone) || isset($order->couple_emergency_contact_phone))
                    <tr>
                        <td><strong>Emergency Contact Phone</strong></td>
                        @if (strtolower($order->emergency_contact_phone) == strtolower(optional($order->retreatant)->emergency_contact_phone))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('emergency_contact_phone', $order->emergency_contact_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->retreatant)->emergency_contact_phone }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower($order->couple_emergency_contact_phone) == strtolower(optional($order->couple)->emergency_contact_phone))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {!! Form::text('couple_emergency_contact_phone', $order->couple_emergency_contact_phone, ['class' => 'form-control']) !!}
                            {{ optional($order->couple)->emergency_contact_phone }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->deposit_amount))
                    <tr>
                        <td><strong>Deposit</strong></td>
                        @if ($order->deposit_amount <> $order->unit_price)
                            <td class='table-danger' data-toggle="tooltip" data-placement="top" title="Order total and Unit Price Do Not Match. Review carefully as possibly more than one item ordered.">
                                Unit Price: {{ $order->unit_price }} *
                        @else
                            <td class='table-secondary'>
                        @endIf
                        {!! Form::number('deposit_amount', $order->deposit_amount, ['class' => 'form-control','step'=>'0.01']) !!}
                        @if (optional($order->registration)->deposit == ($order->is_couple) ? ($order->deposit_amount/2) : $order->deposit_amount )
                            <div class='table-success'>
                        @else
                            <div class='table-danger'>
                        @endIf
                            {{ optional($order->registration)->deposit }}
                            @if ($order->is_couple)
                                (Couple - Deposit split)
                            @endIf
                            </div>
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
                        <td class='table-secondary'>
                            {!! Form::text('order_number', $order->order_number, ['class' => 'form-control']) !!}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                </tbody>
            </table>

            <hr>

            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    @if (!$order->is_processed)
                        @if ($order->contact_id > 0)
                        {!! Form::submit('Proceed with Order',['class' => 'btn btn-dark']) !!}
                        @else
                        {!! Form::submit('Retrieve Contact Info',['class' => 'btn btn-info']) !!}
                        @endif
                    @else
                        <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'index']) }}">Order #{{ $order->order_number }} has already been processed</a>
                    @endIf
                </div>
            </div>
            <hr />
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
