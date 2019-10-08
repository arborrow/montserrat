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
                            <th>Husband ID</th>
                            <th>Wife ID</th>
                            <th>Husband Address</th>
                            <th>Wife Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($couples as $couple)
                        <tr>
                            <td>{{ $couple->id }}</td>
                            <td><a href="{{ URL('person/'.$couple->husband_id) }}">{{ $couple->husband_id }}</a></td>
                            <td><a href="{{ URL('person/'.$couple->wife_id) }}">{{ $couple->wife_id }}</a></td>
                            <td>{{ $couple->husband_address }}</td>
                            <td>{{ $couple->wife_address }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
