@extends('envelope9x6')

@section('content')

    <table width=95%>
        <tr>
            <td class='return-address' width=25%>
              @if($person->logo)
                <img src="{{URL('/images/mrhlogoblack.png')}}" height="70"> <br />
                <hr>
                600 N. Shady Shores Dr <br />
                P.O. Box 1390 <br />
                Lake Dallas, TX 75065 <br />
             @endIf
            </td>
            <td class='delivery-address' width=75%>
                <div>
                {{$person->addressee}} <br />
                {{$person->address_primary_street}} <br />
                @if (!is_null($person->address_primary_supplemental_address))
                    {{ $person->address_primary_supplemental_address  }} <br />
                @endIf
                {{$person->address_primary_city}}, {{$person->address_primary_state}}  {{$person->address_primary_postal_code}}
                </div>
            </td>
        </tr>
    </table>
@stop
