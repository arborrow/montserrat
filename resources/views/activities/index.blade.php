@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Activity Index</span>
                        <span class="grey">({{$activities->total()}} records)</span>
                        @can('update-activity')
                            <span class="create">
                                <a href={{ action('ActivityController@create') }}>{!! Html::image('images/create.png', 'Add Activity',array('title'=>"Add Activity",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                         @endCan
                    </h1>
                    <span>{!! $activities->render() !!}</span>
                </div>
                @if ($activities->isEmpty())
                    <p>It is a brand new world, there are no activities!</p>
                @else
                <table class="table table-bordered table-striped table-hover table-responsive"><caption><h2>Activities</h2></caption>
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

                        @foreach($activities as $activity)
                        <tr>

                            <td style="width:17%"><a href="activity/{{ $activity->id}}">{{ date('M d, Y g:i A', strtotime($activity->touched_at)) }}</a></td>
                            <td style="width:17%">{!! $activity->targets_full_name_link ?? 'Unknown contact(s)' !!} </td>
                            <td style="width:17%">{!! $activity->assignees_full_name_link ?? 'Unknown assignee(s)' !!} </td>
                            <td style="width:5%">{{ $activity->activity_type_label }}</td>
                            <td style="width:44%">{{ $activity->details }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
                {!! $activities->render() !!}

                @endif
            </div>
        </div>
    </section>
@stop
