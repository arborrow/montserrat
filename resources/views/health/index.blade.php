@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Database Health Checks</span>
                    </h1>
                </div>
                @if (empty($results))
                    <p>It is a brand new world, there are no database health results!</p>
                @else
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>Name of database check</th>
                                <th>Results</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $check=>$result)
                            @if($result->count()==0)
                              <tr class="table-success">
                            @else
                              <tr class="table-warning">
                            @endIf
                                <td>{{ $check }} ({{$result->count()}})</td>
                                <td>
                                  @if($result->count()==0)
                                    Passed
                                  @else
                                      <table class="table-danger">
                                        @foreach($result as $field)
                                        @if($loop->first)
                                          <thead><tr>

                                          @foreach($field as $column=>$value)
                                            <th>{{$column}}</th>
                                          @endforeach

                                          </tr></thead>
                                        @endIf
                                        <tbody>
                                          <tr>@foreach($field as $column=>$value)
                                            <td>{{$value}}</td>
                                          @endforeach
                                        </tr>
                                        </tbody>
                                        @endforeach
                                      </table>
                                  @endIf
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
