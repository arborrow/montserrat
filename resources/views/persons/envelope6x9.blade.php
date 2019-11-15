@extends('envelope6x9')

@section('content')

    <table>
        <tr>
            <td class='return-address'>
                <img src="{{URL('/images/mrhlogoblack.png')}}" height="70"> <br />
                600 N. Shady Shores Dr <br />
                P.O. Box 1390 <br />
                Lake Dallas, TX 75065 <br />
            </td>
            <td class='delivery-address'>
                <div>
                {{$person->agc_household_name}} <br />
                {{$person->address_primary_street}} <br />
                {{$person->address_primary_city}}, {{$person->address_primary_state}}  {{$person->address_primary_postal_code}}
                </div>
            </td>
        </tr>
    </table>
@stop
