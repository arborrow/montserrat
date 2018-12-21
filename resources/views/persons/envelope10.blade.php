@extends('envelope10')

@section('content')

{{$person->full_name}} <br />
{{$person->address_primary_street}} <br />
{{$person->address_primary_city}}, {{$person->address_primary_state}}  {{$person->address_primary_postal_code}}