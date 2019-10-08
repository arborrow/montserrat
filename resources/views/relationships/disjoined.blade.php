@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Disjoined Couples Index ({{ $couples->count() }})</span>
                </div>
                @if ($couples->isEmpty())
                    <p>Aleluya, there are no disjoined couples!</p>
                @else
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Relationship ID</th>
                            <th>Husband</th>
                            <th>Wife</th>
                            <th>Husband Address</th>
                            <th>Wife Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($couples as $couple)
                        <tr>
                            <td>{{ $couple->id }}</td>
                            <td><a href="{{ URL('person/'.$couple->husband_id) }}">{{ $couple->husband_name }}</a></td>
                            <td><a href="{{ URL('person/'.$couple->wife_id) }}">{{ $couple->wife_name }}</a></td>
                            <td>
                              <a href="{{ URL('relationship/rejoin/'.$couple->id.'/'.$couple->husband_id)}}">{{ $couple->husband_address }}<br />{{ $couple->husband_city }} {{ $couple->husband_zip }}</a>
                              <br />
                              <a href="https://maps.google.com/?q={{$couple->husband_address}} {{ $couple->husband_city }} {{ $couple->husband_zip }}" target="_blank">Google Map</a>
                            </td>
                            <td>
                              <a href="{{ URL('relationship/rejoin/'.$couple->id.'/'.$couple->wife_id)}}">{{ $couple->wife_address }}<br />{{ $couple->wife_city }} {{ $couple->wife_zip }}</a>
                              <br />
                              <a href="https://maps.google.com/?q={{$couple->wife_address}} {{ $couple->wife_city }} {{ $couple->wife_zip }}"  target="_blank">Google Map</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
