@extends('envelope10')

@section('content')

{{$person->agc_household_name}} <br />
{{$person->address_primary_street}} <br />
{{$person->address_primary_city}}, {{$person->address_primary_state}}  {{$person->address_primary_postal_code}}
