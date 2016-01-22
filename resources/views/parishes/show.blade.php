@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>{!! $parish->name !!} (<a href="../diocese/{{$parish->diocese_id}}">{{ $parish->diocese->name}}</a>)</span>
                    <span class="back"><a href={{ action('ParishesController@index') }}>{!! Html::image('img/parish.png', 'Parish Index',array('title'=>"Parish Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        <span><h2>Address</h2>
                            <address>
                                <a href="http://maps.google.com/?q={{$parish->address1}} {{ $parish->address2}} {{ $parish->city}} {{ $parish->state}} {{ $parish->zip}}" target="_blank">
                                
                                {{ $parish->address1}}<br />
                                @if (!empty($parish->address2))
                                    {{$parish->address2}}<br />
                                @endif   
                                {{$parish->city}} {{$parish->state}} {{ $parish->zip}}</a> 
                                <br />@if ($parish->country='USA') @else {{$parish->country}} 
                                @endif 
                            </address>
                        </span>
                    </div>    
                    
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Phone: </strong>{{ $parish->phone}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Fax: </strong>{{ $parish->fax}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Email: </strong><a href='mailto:{{ $parish->email}}'>{{ $parish->email}}</a></div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Webpage: </strong><a href="{{ $parish->webpage}}" target='_blank'>{{ $parish->webpage}}</a></div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Pastor: </strong>
                        @if ($parish->pastor_id)
                            <a href="../person/{{ $parish->pastor_id}}">{{ $parish->pastor->title or ''}} {{ $parish->pastor->firstname or '' }} {{ $parish->pastor->lastname or 'No pastor assigned'}}</a>
                        @else
                            No pastor assigned
                        @endIf
                    </div>
                </div><div class="clearfix"> </div>
                
                <div class='row'>
                    <div class='col-md-6'><strong>Notes: </strong>{{ $parish->notes}}</div>
                </div><div class="clearfix"> </div>
            </div>    
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('ParishesController@edit', $parish->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['parish.destroy', $parish->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div>
            <hr />
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2><span class="grey">Parishioner Index</span></h2> 
                </div>
                @if (!isset($parish->parishioners))
                    <p>No parishioners are currently registered in the database.</p>
                @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th> 
                            <th>Address</th>
                            <th>City</th>
                            <th>Zip</th> 
                            <th>Phone</th> 
                            <th>Mobile</th> 
                            <th>Email</th> 
                       </tr>
                    </thead>
                    <tbody>
                        @foreach($parish->parishioners as $parishioner)
                        <tr>
                            <td><a href="../person/{{$parishioner->id}}">{{ $parishioner->lastname }}, {{ $parishioner->firstname }}</a></td>
                            <td>{{ $parishioner->address1 }}</td>
                            <td>{{ $parishioner->city }}</td>
                            <td>{{ $parishioner->zip }}</td>
                            <td>{{ $parishioner->phone }}</td>
                            <td>{{ $parishioner->mobile }}</td>
                            <td>{{ $parishioner->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop