@extends('certificate')
@section('content')

<div class="box" style="border: 2px solid black; padding: 4pt;">
    <div class="box-inner" style="border: 2px solid black; padding: 4pt;">
        <br>
        <span class="logo">
            {!! Html::image('images/mrhlogoblack.png','Home',array('title'=>'Home','class'=>'logo','align'=>'center')) !!}
        </span>

        <h1>A Retreat Gift Certificate for</h1>

        <h2>{{ $gift_certificate->recipient->display_name }}</h2>

        <p>You are cordially invited for a weekend retreat of your choice</p>
            
        <h3>From: {{ $gift_certificate->purchaser->display_name }}</h3>

        <p>Gift Certificate must be presented at your retreat.
            Kindly call to confirm your reservation.</p>
    
        <h3>Certificate #{{$gift_certificate->certificate_number}} (Expires: {{$gift_certificate->expiration_date->format('m-d-Y')}})</h3>
        
        <p>Value: ${{$gift_certificate->formatted_funded_amount}}</p>
            
        <span class='pagefooter'>
            600 N Shady Shores Drive<br />
            Lake Dallas, TX 75065<br />
            (940) 321-6020<br />
            <a href='https://montserratretreat.org/' target='_blank'>montserratretreat.org</a>
        </span>
    <br>
    </div>
</div>
@stop
