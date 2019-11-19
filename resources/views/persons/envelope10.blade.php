@extends('envelope10')

@section('content')
  <table width=95%>
      <tr>
          <td class='return-address'>
            @if($person->logo)
              <img src="{{URL('/images/mrhlogoblack.png')}}" height="60"> <br />
              <hr>
              600 N. Shady Shores Dr <br />
              P.O. Box 1390 <br />
              Lake Dallas, TX 75065 <br />
           @endIf
          </td>
          <td class='delivery-address'>
              <div>
              {{$person->addressee}} <br />
              {{$person->address_primary_street}} <br />
              {{$person->address_primary_city}}, {{$person->address_primary_state}}  {{$person->address_primary_postal_code}}
              </div>
          </td>
      </tr>
  </table>
@stop
