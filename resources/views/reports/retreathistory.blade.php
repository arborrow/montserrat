@extends('reportlandscape')
@section('content')

<div class ="retreatlisting">
@if (!$all_retreatants->isEmpty())
<h2>Retreat History for Retreat #{{$all_retreatants[0]->retreat->idnumber}} - {{$all_retreatants[0]->retreat->title}}</h2> 
     
<hr />
 <table width="100%">
        <th class="row-1 row-name">ContactID</th>
        <th class="row-2 row-address">Lastname</th>
        <th class="row-3 row-city">Firstname</th>
        <th class="row-4 row-phone">Fullname</th>
        <th class="row-5 row-phone">Displayname</th>
        <th class="row-6 row-phone">PrimaryEmail</th>
        <th class="row-7 row-notes">PrimaryPhone</th>
        <th class="row-8 row-notes">PrimaryAddress</th>
    
                
    @foreach($all_retreatants as $registration)
    
    <tr>
        <td>{{$registration->contact_id}}</td>
        <td>{{$registration->retreatant->last_name}}</td>
        <td>{{$registration->retreatant->first_name}}</td>
        <td>{{$registration->retreatant->full_name}}</td>
        <td>{{$registration->retreatant->display_name}}</td>
        <td>{{$registration->retreatant->email_primary_text}}</td>
        <td>{{$registration->retreatant->primary_phone_number}}</td>
        <td>{{$registration->retreatant->address_primary_google_map}}</td>
        
    </tr>    
    @endforeach
   @endIf    
</table>
<br />

<hr />
<strong>{{$all_retreatants->count()}} Registered Retreatant(s) as of {{date('l, F j, Y')}}</strong>
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