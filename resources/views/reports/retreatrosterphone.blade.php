@extends('report')
@section('content')

<div class ="retreatroster">
@if (!$registrations->isEmpty())

<h2>Retreat #{{$registrations[0]->retreat->idnumber}} Phone Roster - {{$registrations[0]->retreat->title}}</h2>

<hr />
 <table width="100%">
     <tr>
        <th class="row-1 row-name" style='width: 10%'>Contact ID</th>
        <th class="row-2 row-name" style='width: 20%'>Full name</th>
        <th class="row-3 row-name" style='width: 20%'>Primary Phone</th>
     <tr>
    @foreach($registrations as $registration)

    <tr>
        <td>{{$registration->retreatant->id}}</td>
        <td>{{$registration->retreatant->full_name}}</td>
        <td>{{$registration->retreatant->primary_phone_number}}</td>
    </tr>
    @endforeach

</table>
@endIf
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
