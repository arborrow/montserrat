@extends('report')
@section('content')

<div class ="retreatroster">

<h2>Retreat #{{$registrations[0]->retreat->idnumber}} Room Roster - {{$registrations[0]->retreat->title}}</h2> 
     
<hr />
 <table width="00%">
        <th class="row-1 row-name">Full name</th>
        <th class="row-2 row-room">Assigned Room</th>
        <th class="row-3 row-room_preference">Room Preference</th>
        <th class="row-4 row-cancel">Called to Cancel</th>
        
    @foreach($registrations as $registration)
    
    <tr>
        <td>{{$registration->retreatant->display_name}}</td>
        <td>{{ $registration->room_name}}</td>
        <td>{{$registration->retreatant->note_room_preference_text}}</td>
        <td><div class="square">&EmptySmallSquare;</div> </td>
        
    </tr>    
    @endforeach
        
</table>
<br />
<hr />
<strong>{{$registrations->count()}} Registered Retreatant(s) as of {{date('l, F j, Y')}}</strong>
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