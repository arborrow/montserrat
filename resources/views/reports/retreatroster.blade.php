@extends('report')
@section('content')

<div class ="retreatroster">

<h2>Room Roster for Retreat #{{$registrations[0]->retreat->idnumber}} - {{$registrations[0]->retreat->title}}</h2> 
     
<hr />
 <table width="100%">
        <th class="row-1 row-cancel">Called to Cancel</th>
        <th class="row-2 row-room">Room Pref.</th>
        <th class="row-3 row-name">Full name</th>
        
    @foreach($registrations as $registration)
    
    <tr>
        <td><div class="square">&EmptySmallSquare;</div> </td>
        <td>{{$registration->retreatant->roompreference}}</td>
        <td>{{$registration->retreatant->title}} {{$registration->retreatant->firstname}} {{$registration->retreatant->lastname}}</td>
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