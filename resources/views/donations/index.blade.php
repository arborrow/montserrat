@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Donation Index</span>
                        <span class="grey">({{$donations->total()}} records)</span>
                        @can('create-donation')
                            <span class="create">
                                <a href={{ action('DonationController@create') }}>{!! Html::image('img/create.png', 'Add Donation',array('title'=>"Add Donation",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                        @endCan
                    </h1>
                    <span>{!! $donations->render() !!}</span>
                </div>
                @if ($donations->isEmpty())
                    <p>It is an impoverished new world, there are no donations!</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Donations</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Donor</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Terms</th>
                            <th>Retreat</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($donations as $donation)
                        <tr>

                            <td style="width:17%"><a href="donation/{{ $donation->donation_id}}">{{ date('M d, Y g:i A', strtotime($donation->donation_date)) }}</a></td>
                            <td style="width:17%">{!! $donation->contact->contact_link_full_name ?? 'Unknown contact' !!} </td>
                            <td style="width:17%">{{ $donation->donation_description }} </td>
                            <td style="width:5%">{{ $donation->donation_amount }}</td>
                            <td style="width:44%">{{ $donation->terms }}</td>
                            <td style="width:44%">{{ $donation->retreat_id}}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
                {!! $donations->render() !!}

                @endif
            </div>
        </div>
    </section>
@stop
