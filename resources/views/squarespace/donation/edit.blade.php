@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Process SquareSpace Donation #{{ $donation->id }}
            @if (isset($donation->offering_type))
                ({{ $donation->offering_type }})
            @endIf
            @if (isset($donation->fund))
                ({{ $donation->fund }})
            @endIf
        </h1>
    </div>
    <div class="col-lg-12">
        <a class="btn btn-light" data-toggle="collapse" href="#collapsedInstructions" role="button" aria-expanded="false" aria-controls="collapsedInstructions">
            Instructions
        </a>
    </div>
    <div class="collapse" id="collapsedInstructions">
        <div class="card card-body">
            <ul>
                <li>Select the desired <strong><u>Donor</u></strong> from the Donor dropdown list.
                <li>Select the desired <strong><u>Retreat</u></strong> from the Retreat dropdown list.
                <li>If the Donor is an existing contact, <strong><u>click</u></strong> on the <i>Retrieve Contact Info</i> button to retrieve respective contact information.
                <li><strong><u>Review</u></strong> provided Donation information. <strong><u>Correct</u></strong> any typos in the provided information.
                    <strong><u>Remove</u></strong> unwanted Donor information to retain existing contact information.
                <li>When finished, <strong><u>click</u></strong> on the <i>Proceed with Donation</i> button.
                <li>The Squarespace Donation will be updated.
                    If needed, a new contact will be created.
                    The provided contact information will be added/updated.
                    A touchpoint for the Donor's donation is created.
                    A Donation is created.
                <li>n.b. The Donation Payment will <strong><u>not</u></strong> be until it is received via Stripe.
            </ul>
        </div>
    </div>

    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['squarespace.donation.update', $donation->id]]) !!}
        {!! Form::hidden('id', $donation->id) !!}
<hr>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('contact_id', 'Donor: ' .$donation->name) !!}</h3>
                    {!! Form::select('contact_id', $matching_contacts, null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-lg-4 col-md-6">
                    <h3>{!! Form::label('event_id', 'Retreat ID: #'. $donation->idnumber) !!}</h3>
                        {!! Form::select('event_id', $retreats, $donation->event_id, ['class' => 'form-control']) !!}
                    @if (isset($donation->retreat_description))
                        {{ $donation->retreat_description }}
                    @endIf
                </div>
            </div>
            <hr />
            <div class='row'>
                <div class='col-lg-6 bg-primary'>

                    {!! Form::label('name', 'Fullname') !!}
                    {!! Form::text('name', ucwords(strtolower($donation->name)), ['class' => 'form-control']) !!}

                    @if (isset(optional($donation->donor)->id))
                        {!! $donation->donor->contact_link_full_name !!}
                    @endIf
                </div>
            </div>

            <div class='row'>
            @if (strtolower(trim(substr($donation->name,0,strpos($donation->name,' ')))) == strtolower(optional($donation->donor)->first_name))
                <div class='col-lg-3 col-md-6 bg-success'>
            @else
                <div class='col-lg-3 col-md-6 bg-warning'>
            @endif
                {!! Form::label('first_name', 'First Name: ') !!}
                {!! Form::text('first_name', ucwords(strtolower(trim(substr($donation->name,0,strpos($donation->name,' '))))), ['class' => 'form-control']) !!}
                {{ optional($donation->donor)->first_name }}
                </div>

            @if (strtolower(trim(substr($donation->name,strrpos($donation->name,' ')))) == strtolower(optional($donation->donor)->last_name))
                <div class='col-lg-3 col-md-6 bg-success'>
            @else
                <div class='col-lg-3 col-md-6 bg-warning'>
            @endif
                {!! Form::label('last_name', 'Last Name: ') !!}
                {!! Form::text('last_name', ucwords(strtolower(trim(substr($donation->name,strrpos($donation->name,' '))))), ['class' => 'form-control']) !!}
                {{ optional($donation->donor)->last_name }}
                </div>
            </div>

            <div class='row'>
                @if (strtolower(trim($donation->email)) == strtolower(optional($donation->donor)->email_primary_text))
                    <div class='col-lg-3 col-md-6 bg-success'>
                @else
                    <div class='col-lg-3 col-md-6 bg-warning'>
                @endif
                {!! Form::label('email', 'Email: ') !!}
                {!! Form::text('email', trim($donation->email), ['class' => 'form-control']) !!}
                {{ optional($donation->donor)->email_primary_text }}
                </div>

                @if (strtolower(trim($donation->phone)) == strtolower(optional($donation->donor)->primary_phone_number))
                    <div class='col-lg-3 col-md-6 bg-success'>
                @else
                    <div class='col-lg-3 col-md-6 bg-warning'>
                @endif
                {!! Form::label('phone', 'Phone: ') !!}
                {!! Form::text('phone', trim($donation->phone), ['class' => 'form-control']) !!}
                {{ optional($donation->donor)->primary_phone_number }}
                </div>
            </div>


            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    @if (!$donation->is_processed)
                        @if ($donation->contact_id > 0 )
                        {!! Form::submit('Proceed with Contribution',['class' => 'btn btn-dark']) !!}
                        @else
                        {!! Form::submit('Retrieve Contact Info',['class' => 'btn btn-info']) !!}
                        @endif
                    @else
                        <a class="btn btn-primary" href="{{ action([\App\Http\Controllers\SquarespaceDonationController::class, 'index']) }}">Squarespace Contribution #{{ $donation->id }} has already been processed</a>
                    @endIf
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    @if ($donation->contact_id > 0)
                        <strong>Donor:</strong>
                        {!! optional($donation->donor)->contact_link_full_name !!}
                        <br />
                    @endIf
                    @if (isset($donation->event_id))
                        <strong>Retreat:</strong> <a href="{{ URL('/retreat/'.$donation->event_id) }}">{{ $donation->event->retreat_name }}</a><br />
                    @endIf
                    @if (isset($donation->donation_id))
                        <strong>Donation ID:</strong> <a href="{{ URL('/donation/'.$donation->donation_id) }}">{{ $donation->participant_id }}</a><br />
                    @endIf
                    <strong>Message ID:</strong> <a href="{{URL('/mailgun/'.$donation->message_id)}}">{{ $donation->message_id }}</a><br />
                    <strong>Processed:</strong> {{ ($donation->is_processed) ? 'Yes' : 'No' }} <br />
                </div>
            </div>


        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop
