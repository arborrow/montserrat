@extends('report')
@section('content')

<div class ="retreatlisting">

<h2>Retreat Listing for Retreat #{{$registrations[0]->retreat->idnumber}} - {{$registrations[0]->retreat->title}}</h2> 
     
<hr />
 <table width="100%">
        <th class="row-1 row-name">Full name</th>
        <th class="row-2 row-address">Address</th>
        <th class="row-3 row-city">City, State, Zip</th>
        <th class="row-4 row-phone">Cell phone</th>
        <th class="row-5 row-phone">Home phone</th>
        <th class="row-6 row-phone">Work phone</th>
        <th class="row-7 row-notes">Notes</th>

    @foreach($registrations as $registration)
    
    <tr>
        <td>{{$registration->retreatant->title}} {{$registration->retreatant->firstname}} {{$registration->retreatant->lastname}}</td>
        <td>{{$registration->retreatant->address1}}</td>
        <td>{{$registration->retreatant->city}}, {{$registration->retreatant->state}}  {{$registration->retreatant->zip}}</td>
        <td>{{$registration->retreatant->cellphone}}</td>
        <td>{{$registration->retreatant->homephone}}</td>
        <td>{{$registration->retreatant->workphone}}</td> 
        <td>{{$registration->retreatant->notes}}</td>
        
    </tr>    
    @endforeach
        
</table>
<br />
<hr />

        <span class="logo">
            {!! Html::image('img/mrhlogoblack.png','Home',array('title'=>'Home','class'=>'logo','align'=>'right')) !!}
       
        </span>    
    <span class='pagefooter'>
                600 N Shady Shores Drive<br />
                Lake Dallas, TX 75065<br />
                (940) 321-6020<br /> 
            <a href='http://montserratretreat.org/' target='_blank'>montserratretreat.org</a>
        
    </span>
</div>
@stop