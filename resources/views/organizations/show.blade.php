@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>{{ $organization->organization_name }} ({{ $organization->subcontact_type_label }})</h2></span>
                    <span><a href={{ action('OrganizationsController@index') }}>{!! Html::image('img/organization.png', 'Organization Index',array('title'=>"Organization Index",'class' => 'btn btn-default')) !!}</a></span>
                    <span class="btn btn-default">
                        <a href={{ action('TouchpointsController@add',$organization->id) }}>Add Touch point</a>
                    </span>
                    <span class="btn btn-default">
                    <a href={{ action('RegistrationsController@add',$organization->id) }}>Add Registration</a> 
                </span>                

                </div>
                <div class="row">
                <div class='col-md-6'>
                    
                <span><h2>Addresses</h2>
                @foreach($organization->addresses as $address)
                @if (!empty($address->street_address))
                <strong>{{$address->location->display_name}}:</strong>
                
                <address>
                    {!!$address->google_map!!}  
                <br />@if ($address->country_id=1228) @else {{$address->country_id}} @endif 
                </address>
                @endif
                @endforeach
                </span></div></div><div class="clearfix"> </div>
                <div class='row'>
                    
                    <div class='col-md-4'>
                    <span><h2>Phone Numbers</h2>
                        @foreach($organization->phones as $phone)
                        @if(!empty($phone->phone))
                            <strong>{{$phone->location->display_name}} - {{$phone->phone_type}}: </strong>{{$phone->phone}} {{$phone->phone_ext}}<br />
                        @endif
                            @endforeach
                    </span>
                </div>
                
                </div><div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-4'>
                        <span><h2>Electronic Communications</h2>
                            @foreach($organization->emails as $email)
                            @if(!empty($email->email))
                            <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                            @endif
                            @endforeach
                            @foreach($organization->websites as $website)
                            @if(!empty($website->url))
                            <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                            @endif
                            @endforeach
                        </span>
                    </div>
                </div><div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-6'>
                        <h2>Note:</h2> {{ $organization->note_organization_text }}
                        
                    </div>
                    <div class="col-md-12">
            @if ($organization->touchpoints->isEmpty())
                    <h2>It is a brand new world, there are no touch points for this organization!</h2>
                @else
                <table class="table"><caption><h2>Touch points for {{ $organization->display_name }} </h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contacted by</th>
                            <th>Type of contact</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organization->touchpoints as $touchpoint)
                        <tr>
                            <td><a href="touchpoint/{{ $touchpoint->id}}">{{ $touchpoint->touched_at }}</a></td>
                            <td><a href="organization/{{ $touchpoint->staff->id}}">{{ $touchpoint->staff->display_name }}</a></td>
                            <td>{{ $touchpoint->type }}</td>
                            <td>{{ $touchpoint->notes }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
                    </div>
        
                    
                </div><div class="clearfix"> </div>
            </div>            
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('OrganizationsController@edit', $organization->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['organization.destroy', $organization->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
        </div>
    </section>
@stop