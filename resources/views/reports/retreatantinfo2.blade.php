@extends('report')

@section('content')

@foreach($registrations as $registration)
    <h2>Retreatant Information for Retreat #{{$registration->retreat->idnumber}} - {{$registration->retreat->title}}</h2> 


<i>Please review the information below for accuracy and make changes as appropriate.</i>
<table width="100%">
    <tr>
        <td>
            <h2>Name and Address</h2>
        </td>
    </tr>
    <tr>
        <td>{{$registration->retreatant->title}} {{$registration->retreatant->firstname}} {{$registration->retreatant->lastname}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td>{{$registration->retreatant->address1}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td>{{$registration->retreatant->city}}, {{$registration->retreatant->state}}  {{$registration->retreatant->zip}}</td>
        <td><hr/></td>
    </tr>
   
    <tr>
        <td>
            <h2>Personal Contact Information</h2>
        </td>
    </tr>
    <tr>
        <td><strong>Cell Phone:</strong>{{$registration->retreatant->cellphone}}</td>
        <td><hr/></td>
    </tr>
    
    <tr>
        <td><strong>Home Phone:</strong>{{$registration->retreatant->homephone}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Work Phone:</strong>{{$registration->retreatant->workphone}}</td> 
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Email:</strong>{{$registration->retreatant->email}}</td>  
        <td><hr/></td>
    </tr>    
    <tr>
        <td><strong>Preferred contact method:</strong> <br />(Email, Cell, Home, Work, Mail, etc.)</td>  
        <td><hr/></td>
    </tr>    
    <tr><td> </td></tr>
    <tr><td><h2>Emergency Contact Information</h2></td></tr>
    <tr>
        <td><strong>Phone #:</strong>{{$registration->retreatant->emergencycontactphone}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Name:</strong>{{$registration->retreatant->emergencycontactname}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Relationship:<br /></strong></td>
        <td><hr/></td>
    </tr>
        
    <tr>
        <td>
            <h2>Demographics</h2>
        </td>
    </tr>
    
    <tr>    
        <td><strong>Date of Birth:</strong>{{$registration->retreatant->dob}}</td>
        <td><hr/></td>
    </tr>
    <tr>
        <td><strong>Parish (Location):</strong>
            @if (!empty($registration->retreatant->parish->name))
                {{$registration->retreatant->parish->name}} ({{$registration->retreatant->parish->city}})
            @else
                N/A
            @endif
            <br />(If not Catholic, please indicate religious affiliation)</td>
        <td><hr/></td>
    </tr>    

    <tr>
        <td><strong>Occupation:</strong>{{$registration->retreatant->occupation}}</td>
        <td><hr/></td>
        
    </tr>    
    <tr>
        <td><strong>Languages spoken:</strong>{{$registration->retreatant->languages}}</td>
        <td><hr/></td>
        
    </tr>    
    <tr>
        <td><strong>Room Preference:</strong>{{$registration->retreatant->roompreference}}<br />(1st or 2nd Floor) </td>
        <td><hr/></td>
        
    </tr>    
    <tr>
        <td class='box'><strong>Dietary notes:</strong>{{$registration->retreatant->dietary}}</td>
        <td class='box'><strong>Health notes:</strong>{{$registration->retreatant->medical}}</td>
        
    </tr>    
        
</table>
<strong>General Notes:</strong><br /><br /><br />


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
@endforeach