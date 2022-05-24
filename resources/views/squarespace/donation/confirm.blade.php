@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Confirm SquareSpace Donation #{{ $donation->donation_number }} ({{ $donation->retreat_category }})
        </h1>
    </div>
    <div><p><strong>Instructions: </strong>Select the desired retreatant from the dropdown list. Verify that you are registering the retreatant for the correct retreat. When finished, click on the <i>Proceed with Donation</i> button. </p>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['squarespace.donation.update', $donation->id]]) !!}
        {!! Form::hidden('id', $donation->id) !!}
<hr>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('contact_id', 'Retreatant: ' .$donation->name) !!}</h3>
                    {!! Form::select('contact_id', $matching_contacts, null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('event_id', 'Retreat Id#: '. $donation->retreat_idnumber) !!}</h3>
                    {!! Form::select('event_id', $retreats, $donation->event_id, ['class' => 'form-control']) !!}
                    {!! Form::label('retreat_dates', 'Retreat dates: ' . $donation->retreat_dates) !!}
                </div>
            </div>

            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    {!! Form::submit('Proceed with Donation',['class' => 'btn btn-light']) !!}
                </div>

            </div>
            <hr>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <caption>Information from SquareSpace Donation</caption>
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
                            Registration type: {{ $donation->retreat_registration_type }}<br />
                            Deposit amount: {{ $donation->deposit_amount }}<br />
                            Registering Couple?: {{ ($donation->retreat_couple == 1) ? 'Yes' : 'No' }}<br />
                            Comments: {{ $donation->comments }}<br />
                            Other names and phone numbers: {{ $donation->additional_names_and_phone_numbers }} <br />
                        </td>
                        <td>
                            Title: {{ $donation->title }}<br />
                            Name: {{ $donation->name }}<br />
                            Address (Full): {{ $donation->full_address }}<br />
                            Street: {{ $donation->address_street }}<br />
                            Supplemental: {{ $donation->address_street_2 }}<br />
                            City: {{ $donation->address_city }}<br />
                            State: {{ $donation->address_state }}<br />
                            Zip: {{ $donation->address_zip }}<br />
                            Country: {{ $donation->address_country }}<br />

                            Email: {{ $donation->email }} <br />
                            Mobile phone: {{ $donation->mobile_phone }} <br />
                            Home phone: {{ $donation->home_phone }} <br />
                            Work phone: {{ $donation->work_phone }} <br />

                            Dietary: {{ $donation->dietary }} <br />
                            Room preference: {{ $donation->room_preference }} <br />
                            Preferred language: {{ $donation->preferred_language }} <br />
                            Date of Birth: {{ $donation->date_of_birth }} <br />
                            Parish: {{ $donation->parish }} <br />

                            Emergency contact: {{ $donation->emergency_contact }} <br />
                            Emergency contact relationship: {{ $donation->emergency_contact_relationship }} <br />
                            Emergency contact phone: {{ $donation->emergency_contact_phone }} <br />

                        </td>
                        <td>
                            Title: {{ $donation->couple_title }} <br />
                            Name: {{ $donation->couple_name }} <br />
                            Email: {{ $donation->couple_email }} <br />
                            Mobile phone: {{ $donation->couple_mobile_phone }} <br />
                            Date of Birth: {{ $donation->couple_date_of_birth }} <br />
                            Dietary: {{ $donation->couple_dietary }} <br />
                            Emergency contact: {{ $donation->couple_emergency_contact }} <br />
                            Emergency contact relationship: {{ $donation->couple_emergency_contact_relationship }} <br />
                            Emergency contact phone: {{ $donation->couple_emergency_contact_phone }} <br />
                        </td>
                        <td>
                            Gift certificate #: {{ $donation->gift_certificate_number }} <br />
                            Gift certificate Retreat ID: {{ $donation->gift_certificate_retreat }} <br />
                            Message ID: {{ $donation->message_id }} <br />
                            Event ID: {{ $donation->event_id }} <br />
                            Registration ID: {{ $donation->participant_id }} <br />
                            Email Body: {{ $donation->email_body }} <br />
                            Processed: {{ ($donation->is_processed) ? 'Yes' : 'No' }} <br />
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop
