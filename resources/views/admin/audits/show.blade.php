@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Audit details: <a href="{{ URL($audit->url)}}">{{$audit->url}}</a>
        </h1>
    </div>
    <div class="col-lg-12">

        <div class = "row">
            <div class = "col-lg-3">
                <span class="font-weight-bold">Date: </span> {{$audit->created_at}}<br />
            </div>
            <div class = "col-lg-3">
                <span class="font-weight-bold">User: </span> {{$audit->user_name}}<br />
            </div>
        </div>
        <br>
        <div class = "row">
            <div class = "col-lg-3">
                <span class="font-weight-bold">Action: </span> {{$audit->event}}<br />
            </div>
            <div class = "col-lg-3">
                <span class="font-weight-bold">Entity: </span> {{$audit->auditable_type}}<br />
            </div>
            <div class = "col-lg-3">
                <span class="font-weight-bold">ID: </span> {{$audit->auditable_id}}<br />
            </div>
        </div>
        <br>
        <div class="row">
            <div class = "col-lg-3">
                <span class="font-weight-bold">Old values: </span><br>
                @foreach ($old_values as $field=>$value)
                    {{ $field }}: {{ $value }}<br>
                @endforeach
            </div>
            <div class = "col-lg-3 bg-success">
                <span class="font-weight-bold">New values: </span><br>
                @foreach ($new_values as $field=>$value)
                    {{ $field }}: {{ $value }}<br>
                @endforeach
            </div>
        </div>
        <br>
        <div class = "row">
            <div class = "col-lg-3">
                <span class="font-weight-bold">IP: </span> <a href={{ "https://who.is/whois-ip/ip-address/".$audit->ip_address}} target="_blank">{{ $audit->ip_address }}</a>
            </div>
            <div class = "col-lg-3">
                <span class="font-weight-bold">Agent: </span> {{$audit->user_agent}}
            </div>
            <div class = "col-lg-3">
                <span class="font-weight-bold">Tags: </span> {{$audit->tags}}
            </div>
        </div>
        </div>
    </div>

</div>

@stop
