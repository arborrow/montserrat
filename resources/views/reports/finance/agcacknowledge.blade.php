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
        <td class="board" style="font-size:11pt; line-height:1.3; padding-top:50px;"><div style="font-variant:small-caps"><strong>Board of Trustees</strong></div> <br />
Susie Andrews <br />
<i>President</i> <br /><br />
Mark Vehslage <br />
<i>Secretary Treasurer</i> <br /><br />

Mary Del Olmo <br />
Fr. Manuel Holguin <br />
John Luna <br />
Paul Pederson <br />
Richard Rolland <br />
Jeannette Santos <br />
Fr. Tim Thompson <br /><br />

<div style="font-variant:small-caps"><strong>Jesuit Community</strong></div><br />
Fr. Anthony Borrow, S.J.<br />
Fr. Ron Gonzales, S.J.<br />
Fr. Roy Joseph, S.J.<br />
        </td>
        <td class="main" style="padding-right: 50px; padding-left:20px; padding-top:20px;">
            <div style="position:absolute; right: 0px; padding-right:60px;">{{date('F d, Y')}}</div><br /><br />
            {{$donation->contact->agc_household_name}} <br />
            {{$donation->contact->address_primary_street}} <br />
            {{$donation->contact->address_primary_city}}, {{$donation->contact->address_primary_state}} {{$donation->contact->address_primary_postal_code}}
            <br />
            <br />
            Dear {{$donation->contact->agc_household_name}},<br /><br />
            Jesus promises the door will be opened to those who ask, seek, and knock.
We knocked on your door and you generously answered. Thank you for
your gift of ${{number_format($donation->payments_paid,2)}} for {{$donation->donation_description}} supporting Montserrat
Jesuit Retreat House. We promise you that it will be put to good use.
<br /><br />
People need a place to rest and space to pray. At Montserrat, we never get
tired of encouraging good people to open their hearts to God’s generous
graces. Your gift to the Annual Giving Campaign helps keep Montserrat
growing and available to all who need prayer and counsel for their life in
Christ. Because of you we can continue to minister to God’s people.
<br /><br />Thank you again, and know you are remembered daily in prayers and
masses at Montserrat. St. Ignatius offered this blessing to his friends and so
we now offer it to you: “May it ever please the Lord to recompense and
repay you with his most holy consolations and spiritual blessings and eternal
peace.”<br /><br />
Peace,<br /><br /><br /><br />
Fr. Anthony Borrow, S.J.<br />
Director <br />
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="font-size: 10pt; padding-left:20px;"><i><br /><br />Montserrat Jesuit Retreat House is a ministry of the Society of Jesus UCS Province<br />
                No goods or services have been provided to the donor. <br />
                Your donation is deductible to the extent allowed by law.</i></td>
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
