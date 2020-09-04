@extends('report')
@section('content')
<meta name="format-detection" content="telephone=no">
<div class ="agc_acknowledge">
    <div class ="pageheader">
                <img style="display: block;  margin-left: auto;  margin-right: auto;" src="{{URL('/images/mrhlogoblack.png')}}"> <br />
    </div>

    <div class ="letter">
        <table>
            <tr>
                <td class="board" style="font-size:11pt; line-height:1.3; padding-top:50px;">
                    <div style="font-variant:small-caps">
                        <strong>Board of Trustees</strong>
                    </div><br />
                    @include('snippets.agc_acknowledge.en_US.board')

                    <div style="font-variant:small-caps">
                        <strong>Jesuit Community</strong>
                    </div><br />
                    @include('snippets.agc_acknowledge.en_US.jesuits')
                </td>

                <td class="main" style="padding-right: 50px; padding-left:20px; padding-top:20px;">
                    <div style="position:absolute; right: 0px; padding-right:60px;">{{date('F d, Y')}}</div><br /><br />
                    {{$donation->contact->agc_household_name}} <br />
                    {{$donation->contact->address_primary_street}} <br />
                    {{$donation->contact->address_primary_city}}, {{$donation->contact->address_primary_state}} {{$donation->contact->address_primary_postal_code}}
                    <br />
                    <br />
                    @include('snippets.agc_acknowledge.en_US.letter')

                </td>
            </tr>

            <tr>
                <td></td>
                <td style="font-size: 10pt; padding-left:20px;">
                    <br />
                    <i>
                        @include('snippets.agc_acknowledge.en_US.501c3')
                    </i>
                </td>
            </tr>
        </table>

    </div>
<br />
<br />

<span class='pagefooter' style="font-size:11pt;">
    @include('snippets.agc_acknowledge.en_US.footer')
</span>
</div>
@stop
