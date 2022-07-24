@extends('pdf.pdf_certificate')

@section('content')

<div class="box">
    <div class="box-inner">
        <br>
        <div class ="pdf_header" style="text-align:center;">
            <img style="display: block;  margin-left: auto;  margin-right: auto; height:64px; width:200px;" src="{{ public_path().'/images/mrhlogoblack.png' }}"> <br />
        </div>


        <br>
        <h1>Retreat Gift Certificate for</h1>

        <h2>{{ $gift_certificate->recipient->display_name }}</h2>

        <p>You are cordially invited for a weekend retreat of your choice</p>
            
        <h3>From: {{ $gift_certificate->purchaser->display_name }}</h3>

        <p>Gift Certificate must be presented at your retreat.
            Kindly call to confirm your reservation.</p>
    
        <h3>Certificate #{{$gift_certificate->certificate_number}} (Expires: {{$gift_certificate->expiration_date->format('m-d-Y')}})</h3>
        
        @if ($gift_certificate->funded_amount > 0)
            <p>Value: ${{$gift_certificate->formatted_funded_amount}}</p>
        @endIf
            
        <span class='pagefooter'>
            600 N Shady Shores Drive<br />
            Lake Dallas, TX 75065<br />
            (940) 321-6020<br />
            <a href='https://montserratretreat.org/' target='_blank'>montserratretreat.org</a>
        </span>
        <br>
    <br>
    </div>
</div>
@stop
