@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>{!! $diocese->organization_name !!}</h2></span>
                    <span><a href={{ action('DiocesesController@index') }}>{!! Html::image('img/diocese.png', 'Diocese Index',array('title'=>"Diocese Index",'class' => 'btn btn-primary')) !!}</a></span>
                    <span class="btn btn-primary">
                        <a href={{ action('TouchpointsController@add',$diocese->id) }}>Add Touch point</a>
                    </span>
                </div>
                <div class="row">
                    <div class='col-md-6'>
                    <strong>Bishop(s)</strong><br />
                    @if (empty($diocese->bishops))
                        No Bishop(s) assigned 
                    @else
                        @foreach($diocese->bishops as $bishop)
                            <a href="../person/{{$bishop->contact_id_b}}">{{ $bishop->contact_b->display_name}}</a>
                        @endforeach
                    @endif
                    </div>
                </div><div class="clearfix"> </div>
                <div class="row">
                <div class='col-md-6'>
                    
                <span><h2>Addresses</h2>
                @foreach($diocese->addresses as $address)
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
                        @foreach($diocese->phones as $phone)
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
                            @foreach($diocese->emails as $email)
                            @if(!empty($email->email))
                            <strong>{{$email->location->display_name}} - Email: </strong><a href="mailto:{{$email->email}}">{{$email->email}}</a><br />
                            @endif
                            @endforeach
                            @foreach($diocese->websites as $website)
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
                            @foreach($diocese->notes as $note)
                            @if(!empty($note->note))
                            <strong>{{$note->subject}}: </strong>{{$note->note}} (modified: {{$note->modified_date}})<br />
                            @endif
                            @endforeach
                            
                        </span>
                    </div>
                
                    
                </div><div class="clearfix"> </div>
            </div>            <div class='row'>
                <div class='col-md-1'><a href="{{ action('DiocesesController@edit', $diocese->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['diocese.destroy', $diocese->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
        </div>
    </section>
@stop