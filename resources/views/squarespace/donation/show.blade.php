@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                    <span>
                        <h2>
                            @can('update-squarespace-donation')
                                SquareSpace Donation <a href="{{url('squarespace/donation/'.$donation->id.'/edit')}}">#{{ $donation->id }}</a>
                            @else
                                SquareSpace Donation #{{ $donation->id }}
                            @endCan
                        </h2>
                    </span>
                    <span class="back"><a href={{ action([\App\Http\Controllers\SquarespaceDonationController::class, 'index']) }}>{!! Html::image('images/donation.png', 'SquareSpace Donation Index',array('title'=>"SquareSpace Donation Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>

                <div class='row'>
                    <h3>Donation Information</h3>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Date: </strong>{{ $donation->created_at}}</div>
                    <div class='col-md-3'><strong>Amount: </strong>{{ $donation->amount}}</div>
                    <div class='col-md-3'><strong>Fund: </strong>{{ $donation->fund}}</div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Type: </strong>{{ $donation->offering_type}}</div>
                    <div class='col-md-6'><strong>Description: </strong>{{ $donation->retreat_description}}</div>
                </div>
                <div class="clearfix"> </div>
                <hr />

                <div class='row'>

                    @if (isset($donation->event_id))
                        <div class='col-md-3'>
                            @if (isset($donation->event_id))
                                <strong>Retreat: </strong>
                                    <a href="{{ URL('/retreat/'.$donation->event_id) }}">{{ $donation->event->title .'('.$donation->event->start_date .')'}}</a>
                            @endIf
                        </div>
                        <div class='col-md-3'>
                            <strong>ID Number: </strong>
                            {{ $donation->idnumber}}
                        </div>
                    @endif

                    <div class='col-md-3'>
                        <strong>Message ID: </strong>
                        <a href="{{ URL('/mailgun/'.$donation->message_id) }}">{{ $donation->message_id}}</a>
                    </div>

                </div>
                <div class="clearfix"> </div>

                <hr />

                <div class='row'>
                    <h3>Donor Information</h3>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Name: </strong>{{ $donation->name}}</div>
                    @if (isset($donation->contact_id))
                        <div class='col-md-3'>
                            <strong>Retreatant: </strong>
                            {!! $donation->retreatant->contact_link_full_name !!}
                        </div>
                    @endif

                </div>
                <hr />
                <div class='row'>
                    <div class='col-md-3'><strong>Street: </strong>{{ $donation->address_street}}</div>
                    <div class='col-md-3'><strong>Supplemental: </strong>{{ $donation->address_supplemental}}</div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>City: </strong>{{ $donation->address_city}}</div>
                    <div class='col-md-3'><strong>State: </strong>{{ $donation->address_state}}</div>
                    <div class='col-md-3'><strong>Zip: </strong>{{ $donation->address_zip}}</div>
                    <div class='col-md-3'><strong>Country: </strong>{{ $donation->address_country}}</div>
                </div><div class="clearfix"> </div>
                <hr />

                <div class='row'>
                    <div class='col-md-3'><strong>Email: </strong>{{ $donation->email}}</div>
                    <div class='col-md-3'><strong>Phone: </strong>{{ $donation->phone}}</div>
                </div><div class="clearfix"> </div>
                <hr />

                <div class='row'>
                    <div class='col-md-3'><strong>Comments: </strong>{{ $donation->comments}}</div>
                </div>
                <div class="clearfix"> </div>

                <hr />
                <div class='row'>
                    <div class='col-md-3'>
                        <strong>Is Processed: </strong>
                        {{ ($donation->is_processed) ? 'Yes' : 'No' }}
                    </div>
                </div>

                <div class='row'>
                    @can('update-squarespace-donation')
                        <div class='col-md-1'>
                            <a href="{{ action([\App\Http\Controllers\SquarespaceDonationController::class, 'edit'], $donation->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                        </div>
                    @endCan
                    @can('delete-squarespace-donation')
                        <div class='col-md-1'>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['squarespace.donation.destroy', $donation->id],'onsubmit'=>'return ConfirmDelete()']) !!}
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
