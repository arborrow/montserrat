@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Gate activity</span>
                    </h1>
                    <span>{!! $touchpoints->render() !!}</span>
                </div>
                @if ($touchpoints->isEmpty())
                    <p>It is a brand new world, there is no gate activity!</p>
                @else
                <table class="table table-bordered table-striped table-hover">
                    <caption>
                        <h2>History of gate activity</h2>
                    </caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Activity by</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($touchpoints as $touchpoint)
                        <tr>
                            <td style="width:17%">
                                <a href="{{ URL('touchpoint/' . $touchpoint->id) }} ">
                                    {{ date('M d, Y g:i A', strtotime($touchpoint->touched_at)) }}
                                </a>
                            </td>
                            <td style="width:17%">{!! $touchpoint->staff->contact_link_full_name ?? 'Unknown staff member' !!} </td>
                            <td style="width:44%">{{ $touchpoint->notes }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
                {!! $touchpoints->render() !!}

                @endif
            </div>
        </div>
    </section>
@stop
