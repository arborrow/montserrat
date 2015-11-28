@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>{{ isset($retreatant->title) ? $retreatant->title : null }} 
                {{ isset($retreatant->firstname) ? $retreatant->firstname : null }} 
                {{ isset($retreatant->middlename) ? $retreatant->middlename : null}} 
                {{ $retreatant->lastname}}{{isset($retreatant->suffix) ? ', '.$retreatant->suffix : null }}
                {{ isset($retreatant->nickname) ? "(&quot;$retreatant->nickname&quot;)" : null }}   </span>
                <span class="back"><a href={{ action('RetreatantsController@index') }}>{!! Html::image('img/retreatant.png', 'Retreatant Index',array('title'=>"Retreatant Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
            </div>
            <div class='row'><div class='col-md-4'><span><h2>Address</h2>
                <address>{{ $retreatant->address1}}
                @if (isset($retreatant->address2))
                <br />{{$retreatant->address2}}
                @endif   
                <br />{{$retreatant->city}} {{$retreatant->state}} {{ $retreatant->zip}} 
                <br />@if ($retreatant->country='USA') @else {{$retreatant->country}} @endif </address>
            </span></div>
             <div class='col-md-4'><span class="info">
                    <h2>Emergency Contact Information</h2>
                    <strong>Name: </strong>{{ isset($retreatant->emergencycontactname) ? $retreatant->emergencycontactname : 'N/A' }}
                    <br /><strong>Phone:</strong> {{ isset($retreatant->emergencycontactphone) ? $retreatant->emergencycontactphone : 'N/A' }}
                    <br /><strong>Alt phone:</strong> {{ isset($retreatant->emergencycontactphone2) ? $retreatant->emergencycontactphone2: 'N/A' }}
                </span></div>               
            </div><div class="clearfix"> </div>

            <div class='row'>
                <div class='col-md-4'><span><h2>Phone Numbers</h2><strong>Home phone: </strong>{{$retreatant->homephone}}
                <br /><strong>Work phone: </strong>{{$retreatant->workphone}}   
                <br /><strong>Mobile phone: </strong>{{$retreatant->mobilephone}}     
                <br /><strong>Fax: </strong>{{$retreatant->faxphone}}
                </span></div>
                <div class='col-md-4'><span><h2>Electronic Communications</h2>
                <strong>Email: </strong>{{$retreatant->email}}
                <br /><strong>URL: </strong>{{$retreatant->url}}   
                </span></div></div><div class="clearfix"> </div>

            <div class='row'><span>
                <div class='col-md-8'<span><h2>Demographics:</h2>
                <strong>Gender: </strong>{{$retreatant->gender}}  
                <br /><strong>Ethnicity: </strong>{{$retreatant->ethnicity}}   
                <br /><strong>Parish: </strong>{{$retreatant->parish_id}}     
                <br /><strong>Languages: </strong>{{$retreatant->languages}}</div></span> 
            </div><div class="clearfix"> </div>

            <div class='row'>

                <div class='col-md-4'><span><h2>Medical</h2>
                <strong>Medical notes: </strong>{{$retreatant->medical}}
                <br /><strong>Dietary notes: </strong>{{$retreatant->dietary}}   
                </span></div>
            <div class='col-md-4'><span><h2>Notes</h2>
                <strong>Notes: </strong>{{$retreatant->notes}}
                <br /><strong>Room Preference: </strong>{{$retreatant->roompreference}}
                </span></div>
            </div><div class="clearfix"> </div>                
        </div>
        <div class='row'>
            <div class='col-md-1'><a href="{{ action('RetreatantsController@edit', $retreatant->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
            <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['retreatant.destroy', $retreatant->id]]) !!}
            {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
            {!! Form::close() !!}</div><div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop