@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12 text-center">
        <div class="row">
            <div class="col-lg-12">
                {!!$diocese->avatar_large_link!!}
                <h1>
                    @can('update-contact')
                        <a href="{{url('diocese/'.$diocese->id.'/edit')}}">{{ $diocese->display_name }}</a>
                    @else
                        {{ $diocese->display_name }}
                    @endCan
                </h1>
            </div>
            <div class="col-lg-12">
                {!! Html::link('#notes','Notes',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#touchpoints','Touchpoints',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#relationships','Relationships',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#registrations','Registrations',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#attachments','Attachments',array('class' => 'btn btn-outline-dark')) !!}
                {!! Html::link('#donations','Donations',array('class' => 'btn btn-outline-dark')) !!}
            </div>
            <div class="col-lg-12 mt-3">
                <a href={{ action([\App\Http\Controllers\DioceseController::class, 'index']) }}>
                    {!! Html::image('images/diocese.png', 'Diocese Index', array('title'=>"Diocese Index",'class' => 'btn btn-outline-dark')) !!}
                </a>
                <a href={{ action([\App\Http\Controllers\TouchpointController::class, 'add'],$diocese->id) }} class="btn btn-outline-dark">
                    Add Touchpoint
                </a>
                <a href={{ action([\App\Http\Controllers\RegistrationController::class, 'add'],$diocese->id) }} class="btn btn-outline-dark">
                    Add Registration
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-12 col-lg-6">
                <h2>Bishop(s)</h2>
                @if ($diocese->bishops->isEmpty())
                    <p>No Bishop(s) assigned</p>
                @else
                    @foreach($diocese->bishops as $bishop)
                        <a href="../person/{{$bishop->contact_id_b}}">{{ $bishop->contact_b->full_name}}</a>
                    @endforeach
                @endif
            </div>
            <div class="col-lg-12 col-lg-6">
                <h2>Addresses</h2>
                @foreach($diocese->addresses as $address)
                    @if (!empty($address->street_address))
                        <span class="font-weight-bold">{{$address->location->display_name}}</span>

                        <address>
                            {!!$address->google_map!!}
                        <br />
                        @if ($address->country_id == config('polanco.country_id_usa'))
                        @else {{$address->country_id}}
                        @endif
                        </address>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-lg-6">
                <h2>Phone Numbers</h2>
                @foreach($diocese->phones as $phone)
                    @if(!empty($phone->phone))
                        <span class="font-weight-bold">{{$phone->location->display_name}} - {{$phone->phone_type}}: </span>{{$phone->phone}} {{$phone->phone_ext}}<br>
                    @endif
                @endforeach
            </div>
            <div class="col-lg-12 col-lg-6">
                <h2>Electronic Communications</h2>
                @foreach($diocese->emails as $email)
                    @if(!empty($email->email))
                        <span class="font-weight-bold">{{$email->location->display_name}} - Email: </span><a href="mailto:{{$email->email}}">{{$email->email}}</a><br>
                    @endif
                @endforeach

                @foreach($diocese->websites as $website)
                    @if(!empty($website->url))
                        <span class="font-weight-bold">{{$website->website_type}} - URL: </span><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="notes">
                <h2>Notes for {{ $diocese->display_name }} </h2>
                @if(!empty($diocese->note_diocese->note))
                    <strong>{{$diocese->note_diocese->subject}}: </strong>{{$diocese->note_diocese->note}} (modified: {{$diocese->note_diocese->modified_date}})<br />
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="touchpoints">
                <h2>Touchpoints for {{ $diocese->display_name }} ({{ $touchpoints->total() }})</h2>
                @if ($touchpoints->isEmpty())
                    <div class="text-center">
                        <p>It is a brand new world, there are no touchpoints for this contact!</p>
                    </div>
                @else
                    <table class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Contacted by</th>
                                <th scope="col">Type of contact</th>
                                <th scope="col">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($touchpoints as $touchpoint)
                            <tr>
                                <td><a href="{{url('touchpoint/'.$touchpoint->id)}}">{{ $touchpoint->touched_at }}</a></td>
                                <td>{!! $touchpoint->staff->contact_link_full_name ?? 'Unknown staff member' !!}</td>
                                <td>{{ $touchpoint->type }}</td>
                                <td>{{ $touchpoint->notes }}</td>
                            </tr>
                            @endforeach
                            {{ $touchpoints->links() }}
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="col-lg-12 text-center">
                <span class="btn btn-outline-dark">
                    <a href={{ action([\App\Http\Controllers\TouchpointController::class, 'add'],$diocese->id) }}>Add Touchpoint</a>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="relationships">
                <h2>Relationships for {{$diocese->display_name}} ({{ $diocese->a_relationships->count() + $diocese->b_relationships->count() }})</h2>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    {!! Form::open(['method' => 'POST', 'route' => ['relationship_type.addme']]) !!}
                        <div class="row">
                            <div class="col-lg-12 col-lg-4">
                                {!! Form::label('relationship_type', 'Add Relationship')  !!}
                                {!! Form::select('relationship_type', $relationship_types, NULL, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-lg-12 mt-3">
                                {!! Form::hidden('contact_id',$diocese->id)!!}
                                {!! Form::submit('Create relationship', ['class' => 'btn btn-dark-outline']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-lg-12">
                <ul>
                    @foreach($diocese->a_relationships as $a_relationship)
                        <li>
                          @can('delete-relationship')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $a_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                                {!!$diocese->contact_link!!} {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!}
                                <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                            {!! Form::close() !!}
                          @else
                            {!!$diocese->contact_link!!} {{ $a_relationship->relationship_type->label_a_b }} {!! $a_relationship->contact_b->contact_link !!}
                          @endCan
                        </li>
                    @endforeach

                    @foreach($diocese->b_relationships as $b_relationship)
                        <li>
                          @can('delete-relationship')
                            {!! Form::open(['method' => 'DELETE', 'route' => ['relationship.destroy', $b_relationship->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                                {!!$diocese->contact_link!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link !!}
                                <button type="submit" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash"></i></button>
                            {!! Form::close() !!}
                          @else
                            {!!$diocese->contact_link!!} is {{ $b_relationship->relationship_type->label_b_a }} {!! $b_relationship->contact_a->contact_link !!}
                          @endCan
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="registrations">
                <h2>Registrations for {{ $diocese->display_name }} ({{ $registrations->total() }})</h2>
                {{ $registrations->links() }}
                <div class="col-lg-12">
                    <ul>
                        @foreach($registrations as $registration)
                            <li>{!!$registration->event_link!!} ({{date('F j, Y', strtotime($registration->event->start_date))}} - {{date('F j, Y', strtotime($registration->event->end_date))}}) </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @can('show-attachment')
        <div class="row">
            <div class="col-lg-12" id="attachments">
                <h2>Attachments for {{ $diocese->display_name }} ({{ $files->count() }})</h2>
                @if ($files->isEmpty())
                    <div class="text-center">
                        <p>This user currently has no attachments</p>
                    </div>
                @else
                    <table class="table table-striped table-bordered table-hover table-responsive-md">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Uploaded date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files->sortByDesc('upload_date') as $file)
                            <tr>
                                <td><a href="{{url('contact/'.$diocese->id.'/attachment/'.$file->uri)}}">{{ $file->uri }}</a></td>
                                <td><a href="{{url('attachment/'.$file->id)}}">{{$file->description_text}}</a></td>
                                <td>{{ $file->upload_date}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        @endCan
        @can('show-donation')
            <div class="row">
                <div class="col-lg-12" id="donations">
                    <h2>Donations for {{ $diocese->display_name }} ({{$donations->total() }} donations totaling:  ${{ number_format($donations->sum('donation_amount'),2)}})</h2>
                    @can('create-donation')
                        {!! Html::link(route('donation.add',$diocese->id),'Add donation',array('class' => 'btn btn-outline-dark'))!!}
                    @endCan
                    @if ($donations->isEmpty())
                        <div class="text-center">
                            <p>No donations for this Diocese!</p>
                        </div>
                    @else
                        <table class="table table-striped">
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

                            @foreach($donations->sortByDesc('donation_date')  as $donation)
                                <tr>
                                    <td><a href="../donation/{{$donation->donation_id}}"> {{ $donation->donation_date_formatted }} </a></td>
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

                                    ${{number_format($donation->payments->sum('payment_amount'),2)}}
                                         / ${{ number_format($donation->donation_amount,2) }}
                                        [{{$donation->percent_paid}}%]
                                    </td>

                                    <td> {{ $donation->terms }}</td>
                                    <td> {{ $donation->Notes }}</td>
                                </tr>
                            @endforeach
                            {{ $donations->links() }}
                            </tbody>
                        </table>

                    @endif
                </div>
            </div>
        @endcan
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-contact')
                    <a href="{{ action([\App\Http\Controllers\DioceseController::class, 'edit'], $diocese->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-contact')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['diocese.destroy', $diocese->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>
@stop
