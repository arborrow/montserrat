@extends('pdf.pdf_report')
@section('content')
<meta name="format-detection" content="telephone=no">
<div class ="acknowledgment">

    <table>
    <tr>
        <td class="boardmembers" style="font-size:10pt; font-family:montserrat; width:15%">
            <div style="font-variant:small-caps">
                <strong>Board of Trustees</strong>
            </div> <br />

            @include('snippets.eoy_acknowledgment.en_US.board')
            <br /><br />
            <div style="font-variant:small-caps">
                <strong>Jesuit Community</strong>
            </div><br />
            @include('snippets.eoy_acknowledgment.en_US.jesuits')
        </td>

        <td class="main" style="width: 65%; padding-right: 50px; padding-left:20px; padding-top:20px; font-size:11pt; font-family:montserrat;">
            <div style="position:absolute; right: 0px; padding-right:60px;">
                {{date('F d, Y')}}
            </div><br /><br /><br /><br />
            {{$contact->agc_household_name}} <br />
            {{$contact->address_primary_street}} <br />
            {{$contact->address_primary_city}}, {{$contact->address_primary_state}} {{$contact->address_primary_postal_code}}
            <br />
            <br />
            @include('snippets.eoy_acknowledgment.en_US.letter')
            <div class="signature">
            {!! $montserrat->signature !!}
            </div>
            Fr. Anthony Rauschuber, S.J.<br />
            Director <br />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="font-size: 10pt; font-family: montserrat; padding-left:20px;">
                        <br /><br />
                        @include('snippets.eoy_acknowledgment.en_US.501c3')
                    </td>
                </tr>

    </table>
</div>
@stop
