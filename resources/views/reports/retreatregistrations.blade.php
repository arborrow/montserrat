@extends('report')
@section('content')

<div class ="retreatregistrations">
@if (!$registrations->isEmpty())

<h2>Retreat #{{$registrations[0]->retreat->idnumber}} Registrations by Date of Registration - {{$registrations[0]->retreat->title}}</h2>

<hr />
 <table width="100%">
     <tr>
       <th class="row-1 row-date" style='width: 25%'>Registered On</th>
       <th class="row-2 row-name" style='width: 25%'>Full name</th>
     <tr>
    @foreach($registrations as $registration)

    <tr>
      <td>{{$registration->register_date}}</td>
      <td>{{$registration->retreatant->full_name}}</td>
    </tr>
    @endforeach

</table>
@endIf
<br />
<hr />
<strong>{{$registrations->count()}} Registered Retreatant(s) as of {{date('l, F j, Y')}}</strong>
<hr />


        <span class="logo">
            {!! Html::image('images/mrhlogoblack.png','Home',array('title'=>'Home','class'=>'logo','align'=>'right')) !!}

        </span>
    <span class='pagefooter'>
                600 N Shady Shores Drive<br />
                Lake Dallas, TX 75065<br />
                (940) 321-6020<br />
            <a href='http://montserratretreat.org/' target='_blank'>montserratretreat.org</a>

    </span>
</div>
@stop
