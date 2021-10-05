@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Database Health Index</span>
                    </h1>
                </div>
                @if ($results->isEmpty())
                    <p>It is a brand new world, there are no database health results!</p>
                @else
                <table class="table table-bordered table-striped table-responsive"><caption><h2>results</h2></caption>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Results</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $result->title }}</td>
                            <td>{{ $result->description }}</td>
                            <td>{{ $result->results }}</td>
                            <td>{{ $result->status }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
