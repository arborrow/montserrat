@extends('reportlandscape')
@section('content')

<div class ="retreatlisting">
@if (!$registrations->isEmpty())
<h2>Retreat Listing for Retreat #{{$registrations[0]->retreat->idnumber}} - {{$registrations[0]->retreat->title}}</h2> 
     
<hr />
 <table width="100%">
        <th class="row-1 row-name">Full name</th>
        <th class="row-2 row-address">Address</th>
        <th class="row-3 row-city">City, State, Zip</th>
        <th class="row-4 row-phone">Cell phone</th>
        <th class="row-5 row-phone">Home phone</th>
        <th class="row-6 row-phone">Parish</th>
        <th class="row-7 row-notes">Notes</th>
    
                
    @foreach($registrations as $registration)
    
    <tr>
        <td>{{$registration->retreatant->display_name}}</td>
        <td>{{$registration->retreatant->address_primary_street}}</td>
        <td>{{$registration->retreatant->address_primary_city}}, {{$registration->retreatant->address_primary_state}}  {{$registration->retreatant->address_primary_postal_code}}</td>
        <td>{{$registration->retreatant->phone_home_mobile_number}}</td>
        <td>{{$registration->retreatant->phone_home_phone_number}}</td>
        <td>{{$registration->retreatant->parish_name}}</td> 
        <td>{{$registration->retreatant->note_regsitration_text}}</td>
        
    </tr>    
    @endforeach
   @endIf    
</table>
<br />

<hr />
<strong>{{$registrations->count()}} Registered Retreatant(s) as of {{date('l, F j, Y')}}</strong>
<hr />
        <span class="logo">
            {{ html()->img(asset('images/mrhlogoblack.png'), 'Home')->attribute('title', 'Home')->class('logo')->attribute('align', 'right') }}
       
        </span>    
    <span class='pagefooter'>
                600 N Shady Shores Drive<br />
                Lake Dallas, TX 75065<br />
                (940) 321-6020<br /> 
            <a href='http://montserratretreat.org/' target='_blank'>montserratretreat.org</a>
        
    </span>
</div>
@stop