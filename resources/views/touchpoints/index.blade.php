@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Touchpoint Index</span>
                        <span class="grey">({{$touchpoints->total()}} records)</span>
                        @can('update-touchpoint')
                            <span class="create">
                                <a href={{ action('TouchpointController@create') }}>{!! Html::image('images/create.png', 'Add Touchpoint',array('title'=>"Add Touchpoint",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                            <span class="create">
                                <a href={{ action('TouchpointController@add_group',0) }}>{!! Html::image('images/group_add.png', 'Add Group Touchpoint',array('title'=>"Add Group Touchpoint",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                    </h1>@endCan
                    <span>{!! $touchpoints->render() !!}</span>
                </div>
                @if ($touchpoints->isEmpty())
                    <p>It is a brand new world, there are no touchpoints!</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Touchpoints</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contact Name</th>
                            <th>Contacted by</th>
                            <th>Type</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($touchpoints as $touchpoint)
                        <tr>

                            <td style="width:17%"><a href="touchpoint/{{ $touchpoint->id}}">{{ date('M d, Y g:i A', strtotime($touchpoint->touched_at)) }}</a></td>
                            <td style="width:17%">{!! $touchpoint->person->contact_link_full_name ?? 'Unknown contact' !!} </td>
                            <td style="width:17%">{!! $touchpoint->staff->contact_link_full_name ?? 'Unknown staff member' !!} </td>
                            <td style="width:5%">{{ $touchpoint->type }}</td>
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
