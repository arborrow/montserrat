@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                    <span>
                        <h2>
                            @can('update-squarespace-order')
                                <a href="{{url('squarespace/order/'.$order->id.'/edit')}}">{{ $order->order_description }}</a>
                            @else
                                {{ $order->order_description }}
                            @endCan
                        </h2>
                    </span>
                    <span class="back"><a href={{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'index']) }}>{!! Html::image('images/order.png', 'Squarespace Order Index',array('title'=>"Squarespace Order Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if (isset($order->gift_certificate_number))
                    <div class='row'>
                        <h3>Gift Certificate Information</h3>
                    </div>
                    <div class='row'>
                        <div class='col-md-3'><strong>Gift Certificate Number: </strong>{{ $order->gift_certificate_number}}</div>
                        <div class='col-md-3'><strong>Retreat: </strong>{{ $order->retreat_description}}</div>                    </div>
                    <div class="clearfix"> </div>
                    <hr />
                @endIf
                <div class='row'>
                    <h3>Retreat Information</h3>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>ID Number: </strong>{{ $order->retreat_idnumber}}</div>
                    <div class='col-md-3'><strong>Category: </strong>{{ $order->retreat_category}}</div>
                    <div class='col-md-6'><strong>Description: </strong>{{ $order->retreat_description}}</div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Registration Type: </strong>{{ $order->retreat_registration_type}}</div>
                    <div class='col-md-3'><strong>SS SKU: </strong>{{ $order->retreat_sku}}</div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Dates: </strong>{{ $order->retreat_dates}}</div>
                    <div class='col-md-3'><strong>Start Date: </strong>{{ $order->retreat_start_date}}</div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Deposit amount: </strong>{{ $order->deposit_amount}}</div>
                </div>
                <div class="clearfix"> </div>
                <hr />

                <div class='row'>
                    <h3>Retreatant Information</h3>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Title: </strong>{{ $order->title}}</div>
                    <div class='col-md-3'><strong>Name: </strong>{{ $order->name}}</div>
                </div>
                <hr />
                <div class='row'>
                    <div class='col-md-6'><strong>Full address: </strong>{{ $order->full_address}}</div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Street: </strong>{{ $order->address_street}}</div>
                    <div class='col-md-3'><strong>Supplemental: </strong>{{ $order->address_supplemental}}</div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>City: </strong>{{ $order->address_city}}</div>
                    <div class='col-md-3'><strong>State: </strong>{{ $order->address_state}}</div>
                    <div class='col-md-3'><strong>Zip: </strong>{{ $order->address_zip}}</div>
                    <div class='col-md-3'><strong>Country: </strong>{{ $order->address_country}}</div>
                </div><div class="clearfix"> </div>
                <hr />

                <div class='row'>
                    <div class='col-md-3'><strong>Email: </strong>{{ $order->email}}</div>
                    <div class='col-md-3'><strong>Mobile phone: </strong>{{ $order->mobile_phone}}</div>
                    <div class='col-md-3'><strong>Home phone: </strong>{{ $order->home_phone}}</div>
                    <div class='col-md-3'><strong>Work phone: </strong>{{ $order->work_phone}}</div>
                </div><div class="clearfix"> </div>
                <hr />

                <div class='row'>
                    <div class='col-md-3'><strong>Emergency Contact: </strong>{{ $order->emergency_contact}}</div>
                    <div class='col-md-3'><strong>Relationship: </strong>{{ $order->emergency_contact_relationship}}</div>
                    <div class='col-md-3'><strong>Phone: </strong>{{ $order->emergency_contact_phone}}</div>
                </div><div class="clearfix"> </div>
                <hr />

                <div class='row'>
                    <div class='col-md-3'><strong>Dietary: </strong>{{ $order->dietary}}</div>
                    <div class='col-md-3'><strong>Room Preference: </strong>{{ $order->room_preference}}</div>
                    <div class='col-md-3'><strong>Preferred Language: </strong>{{ $order->preferred_language}}</div>
                    <div class='col-md-3'><strong>Date of Birth: </strong>{{ $order->date_of_birth}}</div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Parish: </strong>{{ $order->parish}}</div>
                    <div class='col-md-3'><strong>Comments: </strong>{{ $order->comments}}</div>
                    @if (isset($order->additional_names_and_phone_numbers))
                        <div class='col-md-3'><strong>Additional Names: </strong>{{ $order->additional_names_and_phone_numbers}}</div>
                    @endIf
                </div>
                <div class="clearfix"> </div>
                <hr />

                @if ($order->is_couple)
                    <div class='row'>
                        <h3>Spouse/Couple Information</h3>
                    </div>
                    <div class='row'>
                        <div class='col-md-3'><strong>Title: </strong>{{ $order->couple_title}}</div>
                        <div class='col-md-3'><strong>Name: </strong>{{ $order->couple_name}}</div>
                        <div class='col-md-3'><strong>Email: </strong>{{ $order->couple_email}}</div>
                        <div class='col-md-3'><strong>Mobile phone: </strong>{{ $order->couple_mobile_phone}}</div>
                    </div>
                    <hr />

                    <div class='row'>
                        <div class='col-md-3'><strong>Emergency Contact: </strong>{{ $order->couple_emergency_contact}}</div>
                        <div class='col-md-3'><strong>Relationship: </strong>{{ $order->couple_emergency_contact_relationship}}</div>
                        <div class='col-md-3'><strong>Phone: </strong>{{ $order->couple_emergency_contact_phone}}</div>
                    </div>
                    <div class="clearfix"> </div>
                    <hr />

                    <div class='row'>
                        <div class='col-md-3'><strong>Dietary: </strong>{{ $order->couple_dietary}}</div>
                        <div class='col-md-3'><strong>Date of Birth: </strong>{{ $order->couple_date_of_birth}}</div>
                    </div>
                    <div class="clearfix"> </div>
                    <hr />
                @endIf

                <div class='row'>
                    @if (isset($order->contact_id))
                        <div class='col-md-3'>
                            <strong>Retreatant: </strong>
                            {!! $order->retreatant->contact_link_full_name !!}
                        </div>
                    @endif
                    @if (isset($order->couple_contact_id))
                        <div class='col-md-3'>
                            <strong>Spouse/Couple: </strong>
                            {!! $order->couple->contact_link_full_name !!}
                        </div>
                    @endif
                    @if (isset($order->event_id))
                        @can('show-retreat')
                            <div class='col-md-3'>
                                <strong>Retreat: </strong>
                                <a href="{{ URL('/retreat/'.$order->event_id) }}">{{ $order->event->title}}</a> ({{$order->event->start_date->format('m-d-Y')}})
                            </div>
                        @endCan
                    @endif
                </div>
                <div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'>
                        <strong>Message ID: </strong>
                        <a href="{{ URL('/mailgun/'.$order->message_id) }}">{{ $order->message_id}}</a>
                    </div>
                    @if (isset($order->participant_id))
                        @can('show-registration')
                            <div class='col-md-3'>
                                <strong>Registration ID: </strong>
                                <a href="{{ URL('/registration/'.$order->participant_id) }}">{{ $order->participant_id}}</a>
                            </div>
                        @endCan
                    @endif
                    @if (isset($order->touchpoint_id))
                        @can('show-touchpoint')
                            <div class='col-md-3'>
                                <strong>Touchpoint ID: </strong>
                                <a href="{{ URL('/touchpoint/'.$order->touchpoint_id) }}">{{ $order->touchpoint_id}}</a>
                            </div>
                        @endCan
                    @endif
                    @if (isset($order->donation_id))
                        @can('show-donation')
                            <div class='col-md-3'>
                                <strong>Donation ID: </strong>
                                <a href="{{ URL('/donation/'.$order->donation_id) }}">{{ $order->donation_id}}</a>
                            </div>
                        @endCan
                    @endif
                </div>
                <div class="clearfix"> </div><hr />
                <div class='row'>
                    <div class='col-md-3'>
                        <strong>Is Processed: </strong>
                        {{ ($order->is_processed) ? 'Yes' : 'No' }}
                    </div>
                </div>

                <div class='row'>
                    @can('update-squarespace-order')
                        <div class='col-md-1'>
                            <a href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'edit'], $order->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                        </div>
                    @endCan
                    @can('delete-squarespace-order')
                        <div class='col-md-1'>
                            {{ html()->form('DELETE', route('squarespace.order.destroy', [$order->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
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
