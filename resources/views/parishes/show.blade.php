@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12 text-center">
        <div class="row">
            <div class="col-12">
                {!!$parish->avatar_large_link!!}
            </div>
            <div class="col-12">
                <h1>
                @can('update-contact')
                    <a href="{{url('parish/'.$parish->id.'/edit')}}">{!! $parish->display_name !!}</a> (<a href="../diocese/{{$parish->diocese_id}}">{{ $parish->diocese_name}}</a>)
                @else
                    {{ $parish->display_name }} (<a href="../diocese/{{$parish->diocese_id}}">{{ $parish->diocese_name}}</a>)
                @endCan
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {!! Html::link('#notes','Notes',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#parishioners','Parishioners',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#touchpoints','Touchpoints',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#relationships','Relationships',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#registrations','Registrations',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#attachments','Attachments',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#donations','Donations',array('class' => 'btn btn-outline-dark')) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <span class="back">
                    <a href={{ action('ParishController@index') }}>
                        {!! Html::image('images/parish.png', 'Parish Index',array('title'=>"Parish Index",'class' => 'btn btn-outline-dark')) !!}
                    </a>
                </span>
                @can('create-touchpoint')
                    <span class="btn btn-outline-dark">
                        <a href={{ action('TouchpointController@add',$parish->id) }}>Add Touchpoint</a>
                    </span>
                @endCan
                <span class="btn btn-outline-dark">
                    <a href={{ action('RegistrationController@add',$parish->id) }}>Add Registration</a>
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 mt-5">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h2>Addresses</h2>
                @foreach($parish->addresses as $address)
                    @if (!empty($address->street_address))
                        <span class="font-weight-bold">{{$address->location->display_name}}:</span>
                        <address>
                            {!!$address->google_map!!}<br>
                            @if ($address->country_id == config('polanco.country_id_usa')) @else {{$address->country_id}} @endif
                        </address>
                    @endif
                @endforeach
            </div>
            <div class="col-12 col-lg-6">
                <h2>Phone Numbers</h2>
                @foreach($parish->phones as $phone)
                @if(!empty($phone->phone))
                    <span class="font-weight-bold">{{$phone->location->display_name}} - {{$phone->phone_type}}: </span>{{$phone->phone}} {{$phone->phone_ext}}<br>
                @endif
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <h2>Electronic Communications</h2>
                @foreach($parish->emails as $email)
                    @if(!empty($email->email))
                        <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                    @endif
                @endforeach
                @foreach($parish->websites as $website)
                    @if(!empty($website->url))
                        <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                    @endif
                @endforeach
            </div>
            <div class="col-12 col-lg-6">
                <h2>Pastor</h2>
                @if (isset($parish->pastor->contact_b))
                    {!! $parish->pastor->contact_b->contact_link_full_name !!}
                @else
                    No pastor assigned
                @endIf
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="notes">
                <h2>Notes for {{ $parish->display_name }} ({{$parish->notes->count()}})</h2>
                @foreach($parish->notes as $note)
                    @if(!empty($note->note))
                        <strong>{{$note->subject}}: </strong>{{$note->note}} (modified: {{$note->modified_date}})<br />
                    @endif
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="parishioners">
                <h2>Parishioners of {{$parish->display_name}} ({{$parish->parishioners->count()}})</h2>
            </div>
            <div class="col-12">
                @if (empty($parish->parishioners))
                    <p>No parishioners are currently registered in the database.</p>
                @else
                    <table class="table table-striped table-hover table-responsive-md">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Primary Address</th>
                                <th>Phone(s)</th>
                                <th>Email(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parish->parishioners as $parishioner)
                            <tr>
                                <td><a href="../person/{{$parishioner->contact_b->id}}">
                                        @if($parishioner->contact_b->is_ambassador)
                                            {!! Html::image('images/ambassador.png', 'Ambassador',array('title'=>"Ambassador",'class' => 'btn btn-outline-dark')) !!}
                                        @endIf
                                        {!! $parishioner->contact_b->contact_link_full_name !!} ({{$parishioner->contact_b->participant_count}})
                                    </a>
                                </td>
                                @if(isset($parishioner->contact_b->address_primary))
                                    <td>
                                        {!!$parishioner->contact_b->address_primary->google_map!!}
                                        <br />
                                        @if ($parishioner->contact_b->address_primary->country_id == config('polanco.country_id_usa')) @else {{$parishioner->contact_b->address_primary->country_id}} @endif
                                    </td>
                                @else <td> </td>
                                @endif
                                <td>
                                    @foreach($parishioner->contact_b->phones as $phone)
                                    @if (!empty($phone->phone))
                                    <strong>{{$phone->location->name}}-{{$phone->phone_type}}:</strong><a href="tel:{{$phone->phone}}">{{$phone->phone }}</a><br />
                                    @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($parishioner->contact_b->emails as $email)
                                    @if (!empty($email->email))
                                        @if ($email->is_primary>0)
                                            <strong>
                                        @endif

                                        {{$email->location->name}}: <a href="mailto:"{{$email->email }}>{{$email->email }}</a><br />
                                        @if ($email->is_primary>0)
                                            </strong>
                                        @endif
                                    @endif

                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="touchpoints">
                <h2>Touchpoints for {{ $parish->display_name }} ({{$parish->touchpoints->count()}})</h2>
            </div>
            <div class="col-12">
                @if ($parish->touchpoints->isEmpty())
                    <p>It is a brand new world, there are no touchpoints for this contact!</p>
                @else
                    <span class="btn btn-outline-dark">
                        <a href={{ action('TouchpointController@add',$parish->id) }}>Add Touchpoint</a>
                    </span>
                    <table class="table table-striped table-hover table-responsive-md">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Contacted by</th>
                                <th>Type of contact</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parish->touchpoints as $touchpoint)
                            <tr>
                                <td><a href="{{url('touchpoint/'.$touchpoint->id)}}">{{ $touchpoint->touched_at }}</a></td>
                                <td><a href="{{url('person/'.$touchpoint->staff->id)}}">{{ $touchpoint->staff->display_name }}</a></td>
                                <td>{{ $touchpoint->type }}</td>
                                <td>{{ $touchpoint->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="relationships">
                <h2>Relationships for {{ $parish->display_name }} ({{$parish->a_relationships->count()+$parish->b_relationships->count()}})</h2>
            </div>
            <div class="col-12 col-lg-6">
                @can('create-relationship')
                    {!! Form::open(['method' => 'POST', 'route' => ['relationship_type.addme']]) !!}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    {!! Form::label('relationship_type', 'Add Relationship: ') !!}
                                </div>
                                <div class="col-6">
                                    {!! Form::select('relationship_type', $relationship_types, NULL, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-6">
                                    {!! Form::hidden('contact_id',$parish->id)!!}
                                    {!! Form::submit('Create relationship', ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                @endcan
            </div>
            <div class="col-12">
                <ul>
                  @foreach($parish->a_relationships as $a_relationship)
                      <li>
                        @can('delete-relationship')
                          {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $a_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                              {!!$parish->contact_link!!} {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!}
                              <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                          {!! Form::close() !!}
                        @else
                          {!!$parish->contact_link!!} {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!}
                        @endCan
                      </li>
                  @endforeach

                  @foreach($parish->b_relationships as $b_relationship)
                      <li>
                        @can('delete-relationship')
                          {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $b_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                              {!!$parish->contact_link!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link !!}
                              <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                          {!! Form::close() !!}
                        @else
                          {!!$parish->contact_link!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link !!}
                        @endCan
                      </li>
                  @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="registrations">
                <h2>Retreat Participation for {{ $parish->display_name }}</h2>
            </div>
            <div class="col-12">
                <ul>
                    @foreach($parish->event_registrations as $registration)
                        <li>{!!$registration->event_link!!} ({{date('F j, Y', strtotime($registration->event->start_date))}} - {{date('F j, Y', strtotime($registration->event->end_date))}}) </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="attachments">
                <h2>Attachments for {{ $parish->display_name }} ({{$files->count()}})</h2>
            </div>
            <div class="col-12">
                @if ($files->isEmpty())
                    <p>This user currently has no attachments</p>
                @else
                    <table class="table table-striped table-hover table-responsive-md">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Uploaded date</th>
                                <th>MIME type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files->sortByDesc('upload_date') as $file)
                            <tr>
                                <td><a href="{{url('contact/'.$parish->id.'/attachment/'.$file->uri)}}">{{ $file->uri }}</a></td>
                                <td>{{$file->description}}</td>
                                <td>{{ $file->upload_date}}</td>
                                <td>{{ $file->mime_type }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="donations">
                <h2>Donations for {{ $parish->display_name }} ({{$parish->donations->count() }} donations totaling:  ${{ number_format($parish->donations->sum('donation_amount'),2)}})</h2>
            </div>
            <div class="col-12">
                @can('create-donation')
                    {!! Html::link(route('donation.add',$parish->id),'Create donation',array('class' => 'btn btn-outline-dark'))!!}
                @endCan
            </div>
            <div class="col-12">
                @if ($parish->donations->isEmpty())
                    <p>No donations for this parish!</p>
                @else
                    <table class="table table-striped table-hover table-responsive-md">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Paid / Pledged</th>
                                <th>Terms</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parish->donations->sortByDesc('donation_date') as $donation)
                                <tr>
                                    <td><a href="{{URL('/donation/'.$donation->donation_id)}}"> {{ $donation->donation_date }} </a></td>
                                    <td> {{ $donation->donation_description.': #'.optional($donation->retreat)->idnumber }}</td>

                                    @if ($donation->donation_amount - $donation->payments->sum('payment_amount') > 0.001)
                                      <td class="alert alert-warning alert-important" style="padding:0px;">
                                    @endIf
                                    @if ($donation->donation_amount - $donation->payments->sum('payment_amount') < -0.001)
                                      <td class="alert alert-danger alert-important" style="padding:0px;">
                                    @endIf
                                    @if (abs($donation->donation_amount - $donation->payments->sum('payment_amount')) < 0.001)
                                      <td>
                                    @endIf

                                     ${{number_format($donation->payments->sum('payment_amount'),2)}} / ${{ number_format($donation->donation_amount,2) }}
                                        [{{$donation->percent_paid}}%]
                                    </td>

                                    <td> {{ $donation->terms }}</td>
                                    <td> {{ $donation->Notes }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-6 text-right">
                <a href="{{ action('ParishController@edit', $parish->id) }}" class="btn btn-info">
                    {!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}
                </a>
            </div>
            <div class="col-6 text-left">
                {!! Form::open(['method' => 'DELETE', 'route' => ['parish.destroy', $parish->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop
