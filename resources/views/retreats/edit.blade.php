@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">MRH Retreat Edit</span> 
                    </h1>
                </div>
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
                        <tr>
                            <td>{{ $ret->idnumber}}</td>
                            <td>{{ $ret->title }}</td>
                            <td>{{ date('F d, Y', strtotime($ret->start)) }}</td>
                            <td>{{ date('F d, Y', strtotime($ret->end)) }}</td>
                            <td>{{ $ret->silent ? 'Yes' : 'No'}}</td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@stop