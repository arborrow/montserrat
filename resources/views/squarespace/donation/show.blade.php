@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class='row'>
                    <h2>
                        @can('update-squarespace-donation')
                            <a href="{{url('squarespace/donation/'.$ss_donation->id.'/edit')}}">SquareSpace Contribution #{{ $ss_donation->id }} </a>
                        @else
                            SquareSpace Contribution #{{ $ss_donation->id }}
                        @endCan
                    </h2>
                </div>
                <div class='row'>
                    <a href={{ action([\App\Http\Controllers\SquarespaceDonationController::class, 'index']) }}>
                        {!! Html::image('images/donation.png', 'SquareSpace Donation Index',array('title'=>"SquareSpace Donation Index",'class' => 'btn btn-primary')) !!}
                    </a>
                </div>
            </div>

            <hr />

            <div class='row'>
                <h3>Contribution from {{ ucwords(strtolower($ss_donation->name)) }}</h3>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>Date: </strong>{{ $ss_donation->created_at}}</div>
                <div class='col-md-3'><strong>Amount: </strong>{{ $ss_donation->amount}}</div>
                <div class='col-md-3'><strong>Fund: </strong>{{ $ss_donation->fund}}</div>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>Type: </strong>{{ $ss_donation->offering_type}}</div>
                <div class='col-md-6'><strong>Description: </strong>{{ $ss_donation->retreat_description}}</div>
            </div>
            <div class="clearfix"> </div>
            <hr />

            <div class='row'>

                @if (isset($ss_donation->event_id))
                    <div class='col-md-3'>
                        @if (isset($ss_donation->event_id))
                            <strong>Retreat #{{ $ss_donation->idnumber }} </strong>
                                <a href="{{ URL('/retreat/'.$ss_donation->event_id) }}">{{ $ss_donation->event->title .'('.$ss_donation->event->start_date .')'}}</a>
                        @endIf
                    </div>
                @endif

                <div class='col-md-3'>
                    <strong>Message ID: </strong>
                    <a href="{{ URL('/mailgun/'.$ss_donation->message_id) }}">{{ $ss_donation->message_id}}</a>
                </div>

            </div>
            <div class="clearfix"> </div>

            <hr />

            <div class='row'>
                <h3>Donor Information</h3>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>Name: </strong>{{ $ss_donation->name}}</div>
                @if (isset($ss_donation->contact_id))
                    <div class='col-md-3'>
                        <strong>Retreatant: </strong>
                        {!! $ss_donation->donor->contact_link_full_name !!}
                    </div>
                @endif

            </div>
            <hr />
            <div class='row'>
                <div class='col-md-3'><strong>Street: </strong>{{ $ss_donation->address_street}}</div>
                <div class='col-md-3'><strong>Supplemental: </strong>{{ $ss_donation->address_supplemental}}</div>
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>City: </strong>{{ $ss_donation->address_city}}</div>
                <div class='col-md-3'><strong>State: </strong>{{ $ss_donation->address_state}}</div>
                <div class='col-md-3'><strong>Zip: </strong>{{ $ss_donation->address_zip}}</div>
                <div class='col-md-3'><strong>Country: </strong>{{ $ss_donation->address_country}}</div>
            </div><div class="clearfix"> </div>
            <hr />

            <div class='row'>
                <div class='col-md-3'><strong>Email: </strong>{{ $ss_donation->email}}</div>
                <div class='col-md-3'><strong>Phone: </strong>{{ $ss_donation->phone}}</div>
            </div><div class="clearfix"> </div>
            <hr />

            <div class='row'>
                <div class='col-md-3'><strong>Comments: </strong>{{ $ss_donation->comments}}</div>
            </div>
            <div class="clearfix"> </div>

            <hr />
            <div class='row'>
                <div class='col-md-3'>
                    <strong>Is Processed: </strong>
                    {{ ($ss_donation->is_processed) ? 'Yes' : 'No' }}
                </div>
            </div>

            <div class='row'>
                @can('update-squarespace-donation')
                    <div class='col-md-1'>
                        <a href="{{ action([\App\Http\Controllers\SquarespaceDonationController::class, 'edit'], $ss_donation->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                    </div>
                @endCan
                @can('delete-squarespace-donation')
                    <div class='col-md-1'>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['squarespace.donation.destroy', $ss_donation->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                        {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                        {!! Form::close() !!}
                    </div>
                @endCan
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</section>
@stop
