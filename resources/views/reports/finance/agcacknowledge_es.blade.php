@extends('report')
@section('content')
<meta name="format-detection" content="telephone=no">
<div class ="agcacknowledge">
<div class ="pageheader">
            <img style="display: block;  margin-left: auto;  margin-right: auto;" src="{{URL('/images/mrhlogoblack.png')}}"> <br />
</table>
</div>
<br />
<div class ="letter">
<table>
    <tr>
        <td class="board" style="font-size:11pt; line-height:1.3; padding-top:50px;">
            <div style="font-variant:small-caps"><strong>La Junta Directiva</strong></div> <br />
Susie Andrews <br />
<i>Presidente</i> <br /><br />
Mark Vehslage <br />
<i>Secretario/Tesoro</i> <br /><br />

Mary Del Olmo <br />
P. Manuel Holguin <br />
John Luna <br />
Paul Pederson <br />
Richard Rolland <br />
Jeannette Santos <br />
P. Tim Thompson <br /><br />

<div style="font-variant:small-caps"><strong>La Comunidad Jesuita</strong></div><br />
P. Antonio Borrow, S.J.<br />
P. Mark McKenzie, S.J.<br />

        </td>
        <td class="main" style="padding-right: 50px; padding-left:20px; padding-top:20px;">
            <div style="position:absolute; right: 0px; padding-right:60px;">{{$donation->today_es }}</div><br /><br />
            {{$donation->contact->agc_household_name}} <br />
            {{$donation->contact->address_primary_street}} <br />
            {{$donation->contact->address_primary_city}}, {{$donation->contact->address_primary_state}} {{$donation->contact->address_primary_postal_code}}
            <br />
            <br />
            Querida familia {{$donation->contact->last_name}},<br /><br />
            Jesús nos promete que la puerta estará abierta para aquellos que piden, buscan y llaman. Nosotros tocamos sobre su puerta y usted respondió generosamente. Agradecemos su donación de
            ${{number_format($donation->payments_paid,2)}} para "{{$donation->donation_description}}" recibida en {{$donation->donation_date_es}} para apoyar la casa de retiros de Montserrat. Tengan por seguro que se le dará un buen uso.
<br /><br />
La gente necesita un lugar para descansar y espacio para orar. Montserrat existe para ayudarlos reconocer la gracia de todas las bendiciones que solo vienen de Dios. Por este motivo, no descansamos hasta que la casa esté llena. Su donación a la Campaña Anual de Donaciones nos ayuda seguir creciendo y poder seguir ofreciendo un espacio de oración y consejo para todos los que estén necesitados y que desean profundizar su relación con Dios. Gracias a usted, podemos seguir apoyando al pueblo de Dios.
<br /><br />Usted y su familia serán recordados diariamente en nuestras oraciones y misas en Montserrat. San Ignacio de Loyola ofreció esta bendición a sus amigos, por lo que ahora se la ofrecemos a ustedes: “Que siempre le complazca al Señor recompensarlo con sus consuelos sagrados, sus bendiciones espirituales y su paz eterna."
<br /><br />
Paz,<br /><br /><br /><br />
P. Antonio Borrow, S.J.<br />
Director <br />
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="font-size: 10pt; padding-left:20px;"><i><br /><br />
            La casa jesuita de retiros de Montserrat es un ministerio de la Sociedad de Jesús, la Provincia de UCS.<br />
                No se han proporcionado bienes o servicios al donante.<br />
                Su donación es deducible en la medida en que la ley lo permita.</i></td>
    </tr>

</table>

</div>
<br /><br />

<span class='pagefooter' style="font-size:11pt;">
    <table style="width:100%; margin:auto;">
        <tr>
            <td style="width:33%; margin:auto; text-align:center">PO Box 1390</td>
            <td style="width:33%; margin:auto; text-align:center">600 N. Shady Shores Dr</td>
            <td style="width:33%; margin:auto; text-align:center">Lake Dallas, TX 75065<td>
        </tr>
            <tr>
            <td style="text-align:center">(940) 321-6020</td>
            <td> </td>
            <td style="text-align:center">montserratretreat.org </td>

        </tr>
    </table>
</span>
</div>
@stop
