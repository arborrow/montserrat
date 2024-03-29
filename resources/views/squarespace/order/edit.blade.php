@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            @if ($order->is_gift_certificate_registration)
                Process Gift Certificate Registration for #{{$order->gift_certificate_full_number}}
            @else
                Process Squarespace Order #{{ $order->order_number }}
            @endIf
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
                @if ($order->is_gift_certificate)
                    <li>Select the desired <strong><u>Purchaser</u></strong> from the Purchaser dropdown list (if the purchaser is found on the dropdown list, otherwise the purchaser will be added as a new contact).
                    <li>Select the desired <strong><u>Recipient</u></strong> from the Recipient dropdown list (if the recipient is found on the dropdown list, otherwise the recipient will be added as a new contact).
                    <li><strong><u>Click</u></strong> on the <i>Retrieve Contact Info</i> button to retrieve respective contact information or to create the new contacts. 
                    <li><strong><u>Review</u></strong> provided Order information. <strong><u>Correct</u></strong> any typos in the provided information.
                        <strong><u>Remove</u></strong> unwanted Order information to retain existing contact information.
                    <li>When finished, <strong><u>click</u></strong> on the <i>Proceed with Order</i> button.
                    <li>The Squarespace Order will be updated.
                        The provided contact information will be added/updated.
                        A gift certificate will be automatically generated and saved as an attachment in the <u>purchaser's</u> profile.
                        A touchpoint for the gift certificate purchase is created.
                        The donation for the gift certificate purchase is also created. 
                    <li>Finally, remember to <strong><u>Fulfill the Squarespace Order</u></strong>.
                @else
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
                    <li>Finally, remember to <a href="https://montserrat-retreat.squarespace.com/config/commerce/orders">Fulfill the Squarespace Order</a>.
                @endif
            </ul>
        </div>
    </div>

    <div class="col-lg-12">
        {{ html()->form('PUT', route('squarespace.order.update', [$order->id]))->open() }}
        {{ html()->hidden('id', $order->id) }}
        <hr>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{{ html()->label(($order->is_gift_certificate ? 'Purchaser: ' : 'Retreatant: ') . $order->name, 'contact_id') }}</h3>
                    {{ html()->select('contact_id', $matching_contacts, isset($order->contact_id) ? $order->contact_id : 0)->class('form-control') }}
                </div>
                <div class="col-lg-4 col-md-6">
                    @if ($order->is_gift_certificate)
                        <h3><strong>Category:</strong> {{ $order->retreat_category  }}</h3>
                    @else
                        <h3>{{ html()->label('Retreat Id#: ' . $order->retreat_idnumber, 'event_id') }}</h3>
                        {{ html()->select('event_id', $retreats, isset($order->event_id) ? $order->event_id : $ids['retreat_id'])->class('form-control') }}
                        <strong>Retreat:</strong> {{ $order->retreat_description  }}<br />
                        <strong>Dates:</strong> {{ $order->retreat_dates}}<br />
                        <strong>Category:</strong> {{ !empty($order->retreat_category) ? $order->retreat_category : $order->event?->retreat_type  }}<br />
                        <strong>Type:</strong> {{ $order->retreat_registration_type }}<br />
                    @endIf
                </div>
                <div class="col-lg-4 col-md-6">
                    @if (isset($order->gift_certificate_id))
                    <h3>Gift Certificate #: 
                        <a href="{{url('gift_certificate/'. $order->gift_certificate_id)}}">
                            {{$order->gift_certificate_full_number}}
                        </a>
                    </h3>
                    @if (!empty($gift_certificate))
                        <strong>Purchased by</strong>: {!!$gift_certificate->purchaser?->contact_link!!}<br />
                        <strong>Recipient</strong>: {!!$gift_certificate->recipient?->contact_link!!}<br />
                        @if ($gift_certificate->expiration_date < now())
                            <div class="bg-danger">
                                <strong>Expiration date</strong>: {{$gift_certificate->expiration_date->format('m-d-Y')}}<br />
                            </div>
                        @else
                            <strong>Expiration date</strong>: {{$gift_certificate->expiration_date->format('m-d-Y')}}<br />
                        @endIf
                    @endif
                        {{ html()->label('Gift Certificate Year Issued:', 'gift_certificate_year_issued')->class('font-weight-bold') }}
                        {{ html()->number('gift_certificate_year_issued', $order->gift_certificate_year_issued)->class('form-control') }}
                        {{ html()->label('Gift Certificate #:', 'gift_certificate_number')->class('font-weight-bold') }}</h3>
                        {{ html()->number('gift_certificate_number', $order->gift_certificate_number)->class('form-control') }}
                    @endif
                    @if (isset($order->comments))
                    <h3>
                        {{ html()->label('Comments: ', 'comments') }}
                    </h3>
                    {{ html()->text('comments', $order->comments)->class('form-control') }}
                    @endIf
                    @if (isset($order->retreat_quantity) && $order->retreat_quantity > 1)
                    <div class='table-danger' data-toggle="tooltip" data-placement="top" title="Quantities greater than 1 need to be manually processed">
                        <h3>{{ html()->label('Quantity: ', 'retreat_quantity') }} *</h3>
                        {{ html()->number('retreat_quantity', $order->retreat_quantity)->class('form-control')->attribute('step', '1') }}
                    </div>
                    @endIf
                    @if (isset($order->additional_names_and_phone_numbers))
                    <div class='table-danger' data-toggle="tooltip" data-placement="top" title="Additional names will need to be manually processed">
                        <h3>Additional Names and Phone Numbers *: </h3>
                        {{ html()->text('additional_names_and_phone_numbers', $order->additional_names_and_phone_numbers)->class('form-control') }}
                    </div>
                    @endIf
                </div>
            </div>

            @if ($order->is_couple)
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{{ html()->label(($order->is_gift_certificate ? 'Recipient: ' : 'Couple: ') . $order->couple_name, 'couple_contact_id') }}</h3>
                    {{ html()->select('couple_contact_id', $couple_matching_contacts, isset($order->couple_contact_id) ? $order->couple_contact_id : 0)->class('form-control') }}
                </div>
            </div>
            @endIf

            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    @if (!$order->is_processed)
                        @if (($order->contact_id > 0 && !$order->is_couple) || (($order->is_couple) && $order->couple_contact_id > 0 && $order->contact_id>0))
                        <a class="btn btn-info" href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'reset'],['order'=>$order->id]) }}">Reset Contact for Order #{{ $order->id }}</a>
                        @else
                        {{ html()->submit('Retrieve Contact Info')->class('btn btn-info') }}
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
                        <th>
                            @if ($order->is_gift_certificate)Purchaser
                                @else Retreatant
                            @endIf
                        </th>
                        @if ($order->is_couple)
                            <th>
                                @if ($order->is_gift_certificate)Recipient
                                @else Couple
                                @endIf
                            </th>
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
                                {{ html()->text('name', ucwords(strtolower($order->name)))->class('form-control') }}
                            </h3>
                            @if (isset($order->retreatant?->id))
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
                                {{ html()->text('couple_name', ucwords(strtolower($order->couple_name)))->class('form-control') }}
                            </h3><br>
                            @if (isset($order->couple?->id))
                            {!! $order->couple->contact_link_full_name !!}
                            @endIf
                        </td>
                        @endIf
                    </tr>
                    <tr>
                        <td><strong>Title</strong></td>
                        @if ($ids['title'] == $order->retreatant?->prefix_id)
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->select('title_id', $prefixes, $ids['title'])->class('form-control') }}
                            {{ $order->retreatant?->prefix_name }}
                        </td>
                        @if ($order->is_couple)
                        @if ($ids['couple_title'] == $order->couple?->prefix_id)
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->select('couple_title_id', $prefixes, $ids['couple_title'])->class('form-control') }}
                            {{ $order->couple?->prefix_name }}
                        </td>
                        @endIf
                    </tr>
                    <tr>
                        <td><strong>First Name</strong></td>
                        @if (strtolower(trim(substr($order->name,0,strpos($order->name,' ')))) == strtolower($order->retreatant?->first_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('first_name', ucwords(strtolower(trim(substr($order->name, 0, strpos($order->name, ' '))))))->class('form-control') }}
                            {{ $order->retreatant?->first_name }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower(trim(substr($order->couple_name,0,strpos($order->couple_name,' ')))) == strtolower($order->couple?->first_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('couple_first_name', ucwords(strtolower(trim(substr($order->couple_name, 0, strpos($order->couple_name, ' '))))))->class('form-control') }}
                            {{ $order->couple?->first_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr class="collapse" id="collapsedMiddleName">
                        <td data-toggle="tooltip" data-placement="top" title="Middle Name field defaults to empty">
                            <strong>Middle Name * </strong>
                        </td>
                        <td class='table-info'>
                            {{ html()->text('middle_name')->class('form-control') }}
                            {{ $order->retreatant?->middle_name }}
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {{ html()->text('couple_middle_name')->class('form-control') }}
                            {{ $order->couple?->middle_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td><strong>Last Name</strong></td>
                        @if (strtolower(trim(substr($order->name,strrpos($order->name,' ')))) == strtolower($order->retreatant?->last_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('last_name', ucwords(strtolower(trim(substr($order->name, strrpos($order->name, ' '))))))->class('form-control') }}
                            {{ $order->retreatant?->last_name }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower(trim(substr($order->couple_name,strrpos($order->couple_name,' ')))) == strtolower($order->couple?->last_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('couple_last_name', ucwords(strtolower(trim(substr($order->couple_name, strpos($order->couple_name, ' '))))))->class('form-control') }}
                            {{ $order->couple?->last_name }}
                        </td>
                        @endIf
                    </tr>

                    <tr class="collapse" id="collapsedNickName">
                        <td data-toggle="tooltip" data-placement="top" title="Nickname field defaults to empty">
                            <strong>Nickname *</strong>
                        </td>
                        <td class='table-info'>
                            {{ html()->text('nick_name')->class('form-control') }}
                            {{ $order->retreatant?->nick_name }}<br>
                        </td>
                        @if ($order->is_couple)
                        <td>
                            {{ html()->text('couple_nick_name')->class('form-control') }}
                            {{ $order->couple?->nick_name }}<br>
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td><strong>Email</strong></td>
                        @if (strtolower(trim($order->email)) == strtolower($order->retreatant?->email_primary_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('email', trim($order->email))->class('form-control') }}
                            {{ $order->retreatant?->email_primary_text }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower(trim($order->couple_email)) == strtolower($order->couple?->email_primary_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('couple_email', $order->couple_email)->class('form-control') }}
                            {{ $order->couple?->email_primary_text }}
                        </td>
                        @endIf
                    </tr>

                    @if (isset($order->mobile_phone))
                    <tr>
                        <td><strong>Mobile Phone</strong></td>
                        @if ($order->mobile_phone_formatted == $order->retreatant?->phone_home_mobile_number )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('mobile_phone', $order->mobile_phone)->class('form-control') }}
                            {{ $order->retreatant?->phone_home_mobile_number }}
                        </td>
                        @if ($order->is_couple)
                        @if ($order->couple_mobile_phone_formatted == $order->couple?->phone_home_mobile_number )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('couple_mobile_phone', $order->couple_mobile_phone)->class('form-control') }}
                            {{ $order->couple?->phone_home_mobile_number }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->home_phone))
                    <tr>
                        <td><strong>Home Phone</strong></td>
                        @if ($order->home_phone_formatted == $order->retreatant?->phone_home_phone_number )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('home_phone', $order->home_phone)->class('form-control') }}
                            {{ $order->retreatant?->phone_home_phone_number }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endif

                    @if (isset($order->work_phone))
                    <tr>
                        <td><strong>Work Phone</strong></td>
                        @if ($order->work_phone_formatted == $order->retreatant?->phone_work_phone_number )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->text('work_phone', $order->work_phone)->class('form-control') }}
                            {{ $order->retreatant?->phone_work_phone_number }}
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
                        @if (ucwords(strtolower(trim($order->address_street))) == ucwords(strtolower($order->retreatant?->address_primary_street)))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('address_street', ucwords(strtolower($order->address_street)))->class('form-control') }}
                            {{ $order->retreatant?->address_primary_street }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address Supplemental</strong></td>
                        @if (trim($order->address_supplemental) == $order->retreatant?->address_primary_supplemental )
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('address_supplemental', $order->address_supplemental)->class('form-control') }}
                            {{ $order->retreatant?->address_primary_supplemental }}
                            @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address City</strong></td>
                        @if (trim(strtolower($order->address_city)) == strtolower($order->retreatant?->address_primary_city))
                        <td class="table-success">
                            @else
                        <td class="table-warning">
                            @endif
                            {{ html()->text('address_city', ucwords(strtolower($order->address_city)))->class('form-control') }}
                            {{ $order->retreatant?->address_primary_city }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address State</strong></td>
                        @if ($ids['address_state'] == $order->retreatant?->address_primary_state_id && isset($ids['address_state']))
                        <td class="table-success">
                            @else
                        <td class="table-warning">
                            @endIf
                            @if (!isset($ids['address_state']))
                            {{ strtoupper($order->address_state)}}
                            @endIf
                            {{ html()->select('address_state_id', $states, $ids['address_state'])->class('form-control') }}
                            {{ $order->retreatant?->address_primary_state }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
                    <tr>
                        <td><strong>Address Zip</strong></td>
                        @if (trim($order->address_zip == $order->retreatant?->address_primary_postal_code))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('address_zip', $order->address_zip)->class('form-control') }}
                            {{ $order->retreatant?->address_primary_postal_code }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->full_address))
                    <tr>
                        <td data-toggle="tooltip" data-placement="top" title="Address Country defaults to US"><strong>Address Country * </strong></td>
                        @if ($ids['address_country'] == $order->retreatant?->address_primary_country_id)
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endif
                            {{ html()->label($order->address_country, 'address_country_id') }}
                            {{ html()->select('address_country_id', $countries, $ids['address_country'])->class('form-control') }}
                            {{ $order->retreatant?->address_primary_country_abbreviation }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->dietary))
                    <tr>
                        <td><strong>Dietary</strong></td>
                        @if (strtolower($order->dietary) == strtolower($order->retreatant?->note_dietary_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('dietary', $order->dietary)->class('form-control') }}
                            {{ $order->retreatant?->note_dietary_text }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower($order->couple_dietary) == strtolower($order->couple?->note_dietary_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('couple_dietary', $order->couple_dietary)->class('form-control') }}
                            {{ $order->couple?->note_dietary_text }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    <tr class="collapse" id="collapsedHealth">
                        <td><strong>Health Note</strong></td>
                        <td class='table-warning'>
                            {{ html()->text('health')->class('form-control') }}
                            {{ $order->retreatant?->note_health_text }}
                        </td>
                        @if ($order->is_couple)
                        <td class='table-warning'>
                            {{ html()->text('couple_health')->class('form-control') }}
                            {{ $order->couple?->note_health_text }}
                        </td>
                        @endIf
                    </tr>

                    <tr>
                        <td><strong>Gender</strong></td>
                        <td class='table-warning'>
                            {{ html()->select('gender_id', $genders)->class('form-control') }}
                        </td>
                        @if ($order->is_couple)
                            <td class='table-warning'>
                                {{ html()->select('couple_gender_id', $genders)->class('form-control') }}
                            </td>
                        @endIf
                    </tr>    

                    @if (isset($order->date_of_birth) || isset($order->couple_date_of_birth))
                    <tr>
                        <td><strong>Date of Birth</strong></td>
                        @if (\Carbon\Carbon::parse($order->date_of_birth) == \Carbon\Carbon::parse($order->retreatant?->birth_date))
                            <td class='table-success'>
                        @else
                            <td class='table-warning'>
                        @endIf
                            {{ html()->text('date_of_birth', $order->date_of_birth)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                            {{ (isset($order->retreatant?->birth_date)) ? date('F d, Y', strtotime($order->retreatant?->birth_date)) : null }}
                        </td>
                        @if ($order->is_couple)
                        @if (\Carbon\Carbon::parse($order->couple_date_of_birth) == \Carbon\Carbon::parse($order->couple?->birth_date))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('couple_date_of birth', $order->couple_date_of_birth)->class('form-control flatpickr-date')->attribute('autocomplete', 'off') }}
                            {{ (isset($order->couple?->birth_date)) ? date('F d, Y', strtotime($order->couple?->birth_date)) : null }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    <tr>
                        <td><strong>Religion</strong></td>
                        <td class='table-warning'>
                            {{ html()->select('religion_id', $religions)->class('form-control') }}
                        </td>
                        @if ($order->is_couple)
                            <td class='table-warning'>
                                {{ html()->select('couple_religion_id', $religions)->class('form-control') }}
                            </td>
                        @endIf
                    </tr>    



                    @if (!($order->room_preference == 'Ninguna' || $order->room_preference == 'No preference' || null == $order->room_preference))
                    <tr>
                        <td><strong>Room Preference</strong></td>
                        @if (strtolower($order->room_preference) == strtolower($order->retreatant?->note_room_preference_text))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('room_preference', $order->room_preference == 'Ninguna' || $order->room_preference == 'None' ? null : $order->room_preference)->class('form-control') }}
                            {{ $order->retreatant?->note_room_preference_text }}
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
                            {{ html()->label(isset($order->preferred_language) ? $order->preferred_language : 'N/A', 'preferred_language_id') }}
                            {{ html()->select('preferred_language_id', $languages, $ids['preferred_language'])->class('form-control') }}
                            {{ $order->retreatant?->preferred_language_label }}
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
                            {{ html()->label(ucwords(strtolower($order->parish)), 'parish') }}
                            {{ html()->hidden('parish', ucwords(strtolower($order->parish))) }}
                            {{ html()->select('parish_id', $parish_list, null !== $order->retreatant?->parish_id ? $order->retreatant?->parish_id : null)->class('form-control') }}
                            {{ $order->retreatant?->parish_name }}
                        </td>
                        @if ($order->is_couple)
                        <td></td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->emergency_contact) || isset($order->couple_emergency_contact))
                    <tr>
                        <td><strong>Emergency Contact</strong></td>
                        @if (strtolower($order->emergency_contact) == strtolower($order->retreatant?->emergency_contact_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('emergency_contact', $order->emergency_contact)->class('form-control') }}
                            {{ $order->retreatant?->emergency_contact_name }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower($order->couple_emergency_contact) == strtolower($order->couple?->emergency_contact_name))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('couple_emergency_contact', $order->couple_emergency_contact)->class('form-control') }}
                            {{ $order->couple?->emergency_contact_name }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->emergency_contact_relationship) || isset($order->couple_emergency_contact_relationship))
                    <tr>
                        <td>
                            <strong>Emergency Contact Relationship</strong>
                        </td>
                        @if (strtolower($order->emergency_contact_relationship) == strtolower($order->retreatant?->emergency_contact_relationship))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('emergency_contact_relationship', $order->emergency_contact_relationship)->class('form-control') }}
                            {{ $order->retreatant?->emergency_contact_relationship }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower($order->couple_emergency_contact_relationship) == strtolower($order->couple?->emergency_contact_relationship))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('couple_emergency_contact_relationship', $order->couple_emergency_contact_relationship)->class('form-control') }}
                            {{ $order->couple?->emergency_contact_relationship }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->emergency_contact_phone) || isset($order->couple_emergency_contact_phone))
                    <tr>
                        <td><strong>Emergency Contact Phone</strong></td>
                        @if (strtolower($order->emergency_contact_phone) == strtolower($order->retreatant?->emergency_contact_phone))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('emergency_contact_phone', $order->emergency_contact_phone)->class('form-control') }}
                            {{ $order->retreatant?->emergency_contact_phone }}
                        </td>
                        @if ($order->is_couple)
                        @if (strtolower($order->couple_emergency_contact_phone) == strtolower($order->couple?->emergency_contact_phone))
                        <td class='table-success'>
                            @else
                        <td class='table-warning'>
                            @endIf
                            {{ html()->text('couple_emergency_contact_phone', $order->couple_emergency_contact_phone)->class('form-control') }}
                            {{ $order->couple?->emergency_contact_phone }}
                        </td>
                        @endIf
                    </tr>
                    @endIf

                    @if (isset($order->deposit_amount) && $order->deposit_amount > 0)
                    <tr>
                        <td><strong>Deposit</strong></td>
                        @if ($order->deposit_amount <> $order->unit_price)
                            <td class='table-danger' data-toggle="tooltip" data-placement="top" title="Order total and Unit Price Do Not Match. Review carefully as possibly more than one item ordered.">
                                Unit Price: {{ $order->unit_price }} *
                        @else
                            <td class='table-secondary'>
                        @endIf
                        {{ html()->number('deposit_amount', $order->deposit_amount)->class('form-control')->attribute('step', '0.01') }}
                        @if ($order->registration?->deposit == ($order->is_couple) ? ($order->deposit_amount/2) : $order->deposit_amount )
                            <div class='table-success'>
                        @else
                            <div class='table-danger'>
                        @endIf
                            {{ $order->registration?->deposit }}
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

                    @if (isset($order->unit_price))
                    <tr>
                        <td><strong>Unit Price</strong></td>
                            <td class='table-secondary'>${{$order->unit_price}}</td>
                        </td>
                    </tr>
                    @endIf

                    @if (isset($order->order_number))
                    <tr>
                        <td><strong>Order #</strong></td>
                        <td class='table-secondary'>
                            {{ html()->text('order_number', $order->order_number)->class('form-control') }}
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
                            {{ html()->submit('Proceed with Order')->class('btn btn-dark') }}
                        @else
                            {{ html()->submit('Retrieve Contact Info')->class('btn btn-info') }}
                        @endif
                        {{ html()->checkbox('send_fulfillment', $send_fulfillment, 1)->class('p-2 m-2') }}
                        {{ html()->label('Send fulfillment email', 'send_fulfillment')->class('p-2 m-2') }}

                    @else
                        <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'index']) }}">Order #{{ $order->order_number }} has already been processed</a>
                    @endIf
                </div>
            </div>
            @if (isset($order->event))
                <div class="row text-center mt-3">

                    @if ($order->event->days_until_start > 8)
                        <div class='col-lg-3 bg-success mx-auto p-2' >
                    @else
                        <div class='col-lg-3 bg-warning mx-auto p-2' >
                    @endif
                    Days until retreat: 
                    {{$order->event->days_until_start}} 
                    </div>
                </div>
            @endIf

            @if (isset($order->event))
                <div class="row text-center mt-3">
                    @if ($order->event->capacity_percentage < 90)
                        <div class='col-lg-3 bg-success mx-auto p-2' >
                    @else 
                        <div class='col-lg-3 bg-warning mx-auto p-2' > 
                    @endIf
                    Capacity: {{$order->event->capacity_percentage}}% </div>
                    </div>
                </div>
            @endif
            
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
        {{ html()->form()->close() }}
    </div>
</div>
@stop
