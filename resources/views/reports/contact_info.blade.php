@extends('report')

@section('content')

<i>Please review the information below for accuracy and make changes as appropriate.</i>
<table width="100%">
    <tr>
        <td>
            <h2>Name and Address</h2>
        </td>
    </tr>
    <tr>
        <td><strong>{{$person->prefix_name}} {{$person->display_name}} {{$person->suffix_name}}</strong></td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>{{$person->address_primary_street}}</strong></td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>{{$person->address_primary_city}}, {{$person->address_primary_state}}  {{$person->address_primary_postal_code}}</strong></td>
        <td><hr/></td>
    </tr>
   
    <tr>
        <td>
            <h2>Phone numbers</h2>
        </td>
    </tr>
    <tr>
        <td><strong>Home phone: </strong>{{$person->phone_home_phone_number}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Mobile phone: </strong>{{$person->phone_home_mobile_number}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Work phone: </strong>{{$person->phone_work_phone_number}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td>
            <h2>Email addresses</h2>
        </td>
    </tr>
    
    @foreach ($person->emails as $email)
    @if (!empty($email->email))
    <tr>
        <td><strong>{{$email->location->name}} - Email: </strong>{{$email->email}}</td>  
        <td><hr/></td>
    </tr>
    @endif
    @endforeach
    <tr>
        <td><strong>Preferred contact method (Email, Cell, Home, Work, Mail, etc.): </strong> {{$person->preferred_communication_method}}</td>  
        <td><hr/></td>
    </tr>    
    <tr><td> </td></tr>
    <tr><td><h2>Emergency Contact Information</h2></td></tr>
    
    <tr>
        <td><strong>Name (Relationship): </strong>{{$person->emergency_contact_name}} 
                @if (!empty($person->emergency_contact_relationship))
                    ({{$person->emergency_contact_relationship}})
                @endIf
        </td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Phone #: </strong>{{$person->emergency_contact_phone}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Alternate Phone #: </strong>{{$person->emergency_contact_phone_alternate}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td>
            <h2>Demographics</h2>
        </td>
    </tr>
    <tr>    
        <td><strong>Gender: </strong>{{$person->gender_name}}</td>
        <td><hr/></td>
    </tr>
    
    <tr>    
        <td><strong>Date of Birth: </strong>{{$person->birth_date}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Parish (Location): </strong>
            {{$person->parish_name}}
            <br />(If not Catholic, please indicate religious affiliation)</td>
        <td><hr/></td>
    </tr>    

    <tr>
        <td><strong>Occupation: </strong>{{$person->occupation_name}}</td>
        <td><hr/></td>
        
    </tr>    
    <tr>
        <td><strong>Ethnicity: </strong>{{$person->ethnicity_name}}</td>
        <td><hr/></td>
        
    </tr>    
    <tr>
        <td><strong>Languages spoken: </strong>
            @foreach ($person->languages as $language)
                {{$language->label}} 
            @endforeach
        </td>
        <td><hr/></td>
        
    </tr>    
    
    <tr>
        <td><strong>Room Preference: </strong>{{$person->note_room_preference_text}}</td>
        <td><hr/></td>
        
    </tr>
    <tr>
        <td>
            <h2>Notes</h2>
        </td>
    </tr>
    <tr>
        <td class='box'><strong>Dietary notes: </strong>{{$person->note_dietary_text}}</td>
        <td class='box'><strong>Health notes: </strong>{{$person->note_health_text}}</td>

    </tr>    
    
</table>
<strong>Additional Notes:</strong><br /><br />


        <span class="logo">
            {!! Html::image('img/mrhlogoblack.png','Home',array('title'=>'Home','class'=>'logo','align'=>'right')) !!}
       
        </span>    
    <span class='pagefooter'>
                600 N Shady Shores Drive<br />
                Lake Dallas, TX 75065<br />
                (940) 321-6020<br /> 
            <a href='http://montserratretreat.org/' target='_blank'>montserratretreat.org</a>
        
    </span>
<div class="page-break"></div>
