@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Confirm SquareSpace Order #{{ $order->order_number }} ({{ $order->retreat_category }})
        </h1>
    </div>
    <div><p><strong>Instructions: </strong>Select the desired retreatant from the dropdown list. Verify that you are registering the retreatant for the correct retreat. When finished, click on the <i>Proceed with Order</i> button. </p>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['squarespace.order.update', $order->id]]) !!}
        {!! Form::hidden('id', $order->id) !!}
<hr>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('contact_id', 'Retreatant: ' .$order->name) !!}</h3>
                    {!! Form::select('contact_id', $matching_contacts, null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('event_id', 'Retreat Id#: '. $order->retreat_idnumber) !!}</h3>
                    {!! Form::select('event_id', $retreats, $order->event_id, ['class' => 'form-control']) !!}
                    {!! Form::label('retreat_dates', 'Retreat: ' . $order->retreat_description . ' (' . $order->retreat_dates .')') !!}
                </div>
            </div>

            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    {!! Form::submit('Proceed with Order',['class' => 'btn btn-light']) !!}
                </div>

            </div>
            <hr>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <caption>Information from SquareSpace Order</caption>
                    <tr>
                        <th>Registration</th>
                        <th>Retreatant</th>
                        <th>Couple</th>
                        <th>Other</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Registration type: {{ $order->retreat_registration_type }}<br />
                            Deposit amount: {{ $order->deposit_amount }}<br />
                            Registering Couple?: {{ ($order->retreat_couple == 1) ? 'Yes' : 'No' }}<br />
                            Comments: {{ $order->comments }}<br />
                            Other names and phone numbers: {{ $order->additional_names_and_phone_numbers }} <br />
                        </td>
                        <td>
                            Title: {{ $order->title }}<br />
                            Name: {{ $order->name }}<br />
                            Address (Full): {{ $order->full_address }}<br />
                            Street: {{ $order->address_street }}<br />
                            Supplemental: {{ $order->address_street_2 }}<br />
                            City: {{ $order->address_city }}<br />
                            State: {{ $order->address_state }}<br />
                            Zip: {{ $order->address_zip }}<br />
                            Country: {{ $order->address_country }}<br />

                            Email: {{ $order->email }} <br />
                            Mobile phone: {{ $order->mobile_phone }} <br />
                            Home phone: {{ $order->home_phone }} <br />
                            Work phone: {{ $order->work_phone }} <br />

                            Dietary: {{ $order->dietary }} <br />
                            Room preference: {{ $order->room_preference }} <br />
                            Preferred language: {{ $order->preferred_language }} <br />
                            Date of Birth: {{ $order->date_of_birth }} <br />
                            Parish: {{ $order->parish }} <br />

                            Emergency contact: {{ $order->emergency_contact }} <br />
                            Emergency contact relationship: {{ $order->emergency_contact_relationship }} <br />
                            Emergency contact phone: {{ $order->emergency_contact_phone }} <br />

                        </td>
                        <td>
                            Title: {{ $order->couple_title }} <br />
                            Name: {{ $order->couple_name }} <br />
                            Email: {{ $order->couple_email }} <br />
                            Mobile phone: {{ $order->couple_mobile_phone }} <br />
                            Date of Birth: {{ $order->couple_date_of_birth }} <br />
                            Dietary: {{ $order->couple_dietary }} <br />
                            Emergency contact: {{ $order->couple_emergency_contact }} <br />
                            Emergency contact relationship: {{ $order->couple_emergency_contact_relationship }} <br />
                            Emergency contact phone: {{ $order->couple_emergency_contact_phone }} <br />
                        </td>
                        <td>
                            Gift certificate #: {{ $order->gift_certificate_number }} <br />
                            Gift certificate Retreat ID: {{ $order->gift_certificate_retreat }} <br />
                            Message ID: {{ $order->message_id }} <br />
                            Event ID: {{ $order->event_id }} <br />
                            Registration ID: {{ $order->participant_id }} <br />
                            Email Body: {{ $order->email_body }} <br />
                            Processed: {{ ($order->is_processed) ? 'Yes' : 'No' }} <br />
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop
