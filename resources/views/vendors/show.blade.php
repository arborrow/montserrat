@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>{!! $vendor->organization_name !!}</span>
                    <span class="back"><a href={{ action('VendorsController@index') }}>{!! Html::image('img/vendor.png', 'Vendor Index',array('title'=>"Vendor Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    <span class="btn btn-primary">
                        <a href={{ action('TouchpointsController@add',$vendor->id) }}>Add Touch point</a>
                    </span>
                </div>
                <div class='row'><div class='col-md-4'>
                <span><h2>Addresses</h2>
                @foreach($vendor->addresses as $address)
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
                        @foreach($vendor->phones as $phone)
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
                            @foreach($vendor->emails as $email)
                            @if(!empty($email->email))
                            <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                            @endif
                            @endforeach
                            @foreach($vendor->websites as $website)
                            @if(!empty($website->url))
                            <strong>{{$website->website_type}} - URL: </strong><a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                            @endif
                            @endforeach
                        </span>
                    </div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'>
                        <span><h2>Notes</h2>
                            @foreach($vendor->notes as $note)
                            @if(!empty($note->note))
                            <strong>{{$note->subject}}: </strong>{{$note->note}} (modified: {{$note->modified_date}})<br />
                            @endif
                            @endforeach
                            
                        </span>
                    </div>
                
                    
                </div><div class="clearfix"> </div>
            </div>    
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('VendorsController@edit', $vendor->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['vendor.destroy', $vendor->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
            
            <div class="panel panel-default">
               
            @if ($vendor->touchpoints->isEmpty())
                    <p>It is a brand new world, there are no touch points for this person!</p>
                @else
            <div class="panel-heading">
                <h2><span class="grey">Touch points for {{ $vendor->display_name }} </span></h2> 
            <span class="btn btn-primary">
                   <a href={{ action('TouchpointsController@add',$vendor->id) }}>Add Touch point</a>
                </span>
            
            </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contacted by</th>
                            <th>Type of contact</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendor->touchpoints as $touchpoint)
                        <tr>
                            <td><a href="../touchpoint/{{ $touchpoint->id}}">{{ $touchpoint->touched_at }}</a></td>
                            <td><a href="../person/{{ $touchpoint->staff->id}}">{{ $touchpoint->staff->display_name }}</a></td>
                            <td>{{ $touchpoint->type }}</td>
                            <td>{{ $touchpoint->notes }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            @endif
            
        </div>
            
        </div>
    </section>
@stop