@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">MRH Retreat Index</span> 
                    </h1>
                </div>
                @if ($retreats->isEmpty())
                    <p> Currently, there are no retreats!</p>
                @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Title</th>
                            <th>Starts</th>
                            <th>Ends</th>
                            <th>Silent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($retreats as $retreat)
                        <tr>
                            <td>{{ $retreat->idnumber}}</td>
                            <td>{{ $retreat->title }}</td>
                            <td>{{ date('F d, Y', strtotime($retreat->start)) }}</td>
                            <td>{{ date('F d, Y', strtotime($retreat->end)) }}</td>
                            <td>{{ $retreat->silent ? 'Yes' : 'No'}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop