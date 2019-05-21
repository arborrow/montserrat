@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Offering Dedup Index</span>
                        <span>({{$offeringdedup->total()}} records)</span>
                        
                        
                    </h1>
                </div>
                @if ($offeringdedup->isEmpty())
                    <p>Success, there are no retreat offering duplicates (contact_id, event_id)!</p>
                @else
                <table class="table table-bordered table-striped table-responsive"><caption><h2>Retreat Offering Duplicates</h2></caption>
                    <thead>
                        <tr>
                            <th>Contact-Event Duplicate</th>
                            <th>Sortname</th>
                            <th>RetreatName (Idnumber)</th>
                            <th>Number of Duplicates</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offeringdedup as $duplicate)
                        <tr>
                            <td><a href="offeringdedup/show/{{$duplicate->contact_id}}/{{$duplicate->event_id}}">{{$duplicate->combo}}</a></td>
                            <td>{{$duplicate->contact->sort_name}}</td>
                            <td>{{$duplicate->retreat_name.' ('.$duplicate->retreat_idnumber.')'}}</td>
                            <td>{{$duplicate->count}}</td>
                            
                        </tr>
                        @endforeach
                       {!! $offeringdedup->render() !!}  
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop