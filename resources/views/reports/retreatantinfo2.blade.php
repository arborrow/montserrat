@extends('report')

@section('content')

@foreach($registrations as $registration)
    <h2>Retreatant Information for Retreat {{$registration->retreat->title}} - Room: {{$registration->room_name}}</h2>


<i>Please review and update the information below and leave this form at the registration desk.</i>
<table width="100%">
    <tr>
        <td>
            <h2>Name and Address ({{ $registration->retreatant->primary_address_location_name }})</h2>
        </td>
    </tr>
	<tr><td>{!!$registration->retreatant->avatar_small_link!!}</td></tr>
    <tr>
        <td><strong>{{$registration->retreatant->prefix_name}} {{$registration->retreatant->display_name}} {{$registration->retreatant->suffix_name}}</strong></td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>{{$registration->retreatant->address_primary_street}}</strong></td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>{{$registration->retreatant->address_primary_city}}, {{$registration->retreatant->address_primary_state}}  {{$registration->retreatant->address_primary_postal_code}}</strong></td>
        <td><hr/></td>
    </tr>

    <tr>
        <td>
            <h2>Phone numbers ({{ $registration->retreatant->primary_phone_location_name }}{{!empty($registration->retreatant->primary_phone_type) ? ' '.$registration->retreatant->primary_phone_type : null  }})</h2>
        </td>
    </tr>
    <tr>
        <td><strong>{{ !empty(($registration->retreatant->phone_home_phone->is_primary)) ? '*' : null }} Home phone: </strong>{{$registration->retreatant->phone_home_phone_number}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>{{ !empty(($registration->retreatant->phone_home_mobile->is_primary)) ? '*' : null }} Mobile phone: </strong>{{$registration->retreatant->phone_home_mobile_number}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>{{ !empty(($registration->retreatant->phone_work_phone->is_primary)) ? '*' : null }} Work phone: </strong>{{$registration->retreatant->phone_work_phone_number}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td>
            <h2>Email addresses ({{ $registration->retreatant->primary_email_location_name }})</h2>
        </td>
    </tr>

    @foreach ($registration->retreatant->emails as $email)
    @if (!empty($email->email))
    <tr>
        <td><strong>{{ ($email->is_primary) ? '*' : null }} {{$email->location->name}} - Email: </strong>{{$email->email}}</td>
        <td><hr/></td>
    </tr>
    @endif
    @endforeach
    <tr>
        <td><h2>Preferred contact method</h2>
    </tr>
    <tr>
        <td><strong>(Email, Phone, Postal Mail, or SMS/Text):</strong>  {{config('polanco.preferred_communication_method.'.$registration->retreatant->preferred_communication_method) }}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td>
            <h2>Demographics</h2>
        </td>
    </tr>
    <tr>
        <td><strong>Gender: </strong>{{$registration->retreatant->gender_name}}</td>
        <td><hr/></td>
    </tr>

    <tr>
        <td><strong>Date of Birth: </strong>{{$registration->retreatant->birthday}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Parish (Location): </strong>
            {{$registration->retreatant->parish_name}}
            <br />(If not Catholic, please indicate religious affiliation)</td>
        <td><hr/></td>
    </tr>

    <tr>
        <td><strong>Occupation: </strong>{{$registration->retreatant->occupation_name}}</td>
        <td><hr/></td>

    </tr>
    <tr>
        <td><strong>Ethnicity: </strong>{{$registration->retreatant->ethnicity_name}}</td>
        <td><hr/></td>

    </tr>
    <tr>
        <td><strong>Languages spoken: </strong>
            @foreach ($registration->retreatant->languages as $language)
                {{$language->label}}
            @endforeach
        </td>
        <td><hr/></td>

    </tr>

    <tr>
        <td><strong>Room Preference: </strong>{{$registration->retreatant->note_room_preference_text}}</td>
        <td><hr/></td>

    </tr>

    <tr><td><h2>Emergency Contact Information</h2></td></tr>

    <tr>
        <td><strong>Name (Relationship): </strong>{{$registration->retreatant->emergency_contact_name}}
                @if (!empty($registration->retreatant->emergency_contact_relationship))
                    ({{$registration->retreatant->emergency_contact_relationship}})
                @endIf
        </td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Phone #: </strong>{{$registration->retreatant->emergency_contact_phone}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Alternate Phone #: </strong>{{$registration->retreatant->emergency_contact_phone_alternate}}</td>
        <td><hr/></td>
    </tr>

    <tr>
        <td>
            <h2>Notes</h2>
        </td>
    </tr>
    <tr>
        <td class='box'><strong>Dietary notes: </strong>{{$registration->retreatant->note_dietary_text}}</td>
        <td class='box'><strong>Health notes: </strong>{{$registration->retreatant->note_health_text}}</td>

    </tr>

</table>
<strong>Additional Notes:</strong><br /><br />


        <span class="logo">
            {{ html()->img(asset('images/mrhlogoblack.png'), 'Home')->attribute('title', 'Home')->class('logo')->attribute('align', 'right') }}

        </span>
    <span class='pagefooter'>
                600 N Shady Shores Drive<br />
                Lake Dallas, TX 75065<br />
                (940) 321-6020<br />
            <a href='http://montserratretreat.org/' target='_blank'>montserratretreat.org</a>

    </span>
<div class="page-break"></div>
@endforeach
@stop
