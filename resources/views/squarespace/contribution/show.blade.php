@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class='row'>
                    <h2>
                        @can('update-squarespace-contribution')
                            <a href="{{url('squarespace/contribution/'.$ss_contribution->id.'/edit')}}">Squarespace Contribution #{{ $ss_contribution->id }} </a>
                        @else
                            Squarespace Contribution #{{ $ss_contribution->id }}
                        @endCan
                    </h2>
                </div>
                <div class='row'>
                    <a href={{ action([\App\Http\Controllers\SquarespaceContributionController::class, 'index']) }}>
                        {{ html()->img(asset('images/donation.png'), 'Squarespace Contribution Index')->attribute('title', "Squarespace Contribution Index")->class('btn btn-primary') }}
                    </a>
                </div>
            </div>

            <hr />

            <div class='row'>
                <h3>Contribution from {{ ucwords(strtolower($ss_contribution->name)) }}</h3>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>Date: </strong>{{ $ss_contribution->created_at}}</div>
                <div class='col-md-3'><strong>Amount: </strong>{{ $ss_contribution->amount}}</div>
                <div class='col-md-3'><strong>Fund: </strong>{{ $ss_contribution->fund}}</div>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>Type: </strong>{{ $ss_contribution->offering_type}}</div>
                <div class='col-md-6'><strong>Description: </strong>{{ $ss_contribution->retreat_description}}</div>
            </div>
            <div class="clearfix"> </div>
            <hr />

            <div class='row'>

                @if (isset($ss_contribution->event_id))
                    <div class='col-md-3'>
                        @if (isset($ss_contribution->event_id))
                            <strong>Retreat #{{ $ss_contribution->idnumber }} </strong>
                                <a href="{{ URL('/retreat/'.$ss_contribution->event_id) }}">{{ $ss_contribution->event->title .'('.$ss_contribution->event->start_date .')'}}</a>
                        @endIf
                    </div>
                @endif

                <div class='col-md-3'>
                    <strong>Message ID: </strong>
                    <a href="{{ URL('/mailgun/'.$ss_contribution->message_id) }}">{{ $ss_contribution->message_id}}</a>
                </div>

            </div>
            <div class="clearfix"> </div>

            <hr />

            <div class='row'>
                <h3>Donor Information</h3>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>Name: </strong>{{ $ss_contribution->name}}</div>
                @if (isset($ss_contribution->contact_id))
                    <div class='col-md-3'>
                        <strong>Retreatant: </strong>
                        {!! $ss_contribution->donor->contact_link_full_name !!}
                    </div>
                @endif

            </div>
            <hr />
            <div class='row'>
                <div class='col-md-3'><strong>Street: </strong>{{ $ss_contribution->address_street}}</div>
                <div class='col-md-3'><strong>Supplemental: </strong>{{ $ss_contribution->address_supplemental}}</div>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>City: </strong>{{ $ss_contribution->address_city}}</div>
                <div class='col-md-3'><strong>State: </strong>{{ $ss_contribution->address_state}}</div>
                <div class='col-md-3'><strong>Zip: </strong>{{ $ss_contribution->address_zip}}</div>
                <div class='col-md-3'><strong>Country: </strong>{{ $ss_contribution->address_country}}</div>
            </div><div class="clearfix"> </div>
            <hr />

            <div class='row'>
                <div class='col-md-3'><strong>Email: </strong>{{ $ss_contribution->email}}</div>
                <div class='col-md-3'><strong>Phone: </strong>{{ $ss_contribution->phone}}</div>
            </div><div class="clearfix"> </div>
            <hr />

            <div class='row'>
                <div class='col-md-3'><strong>Comments: </strong>{{ $ss_contribution->comments}}</div>
            </div>
            <div class="clearfix"> </div>

            <hr />
            <div class='row'>
                <div class='col-md-3'>
                    <strong>Is Processed: </strong>
                    {{ ($ss_contribution->is_processed) ? 'Yes' : 'No' }}
                </div>
            </div>

            <div class='row'>
                @can('update-squarespace-contribution')
                    <div class='col-md-1'>
                        <a href="{{ action([\App\Http\Controllers\SquarespaceContributionController::class, 'edit'], $ss_contribution->id) }}" class="btn btn-info">{{ html()->img(asset('images/edit.png'), 'Edit')->attribute('title', "Edit") }}</a>
                    </div>
                @endCan
                @can('delete-squarespace-contribution')
                    <div class='col-md-1'>
                        {{ html()->form('DELETE', route('squarespace.contribution.destroy', [$ss_contribution->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                        {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                        {{ html()->form()->close() }}
                    </div>
                @endCan
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</section>
@stop
