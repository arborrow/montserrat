@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <span class="grey">{{$audits->total()}} result(s) found</span>
                    <span class="search"><a href={{ action([\App\Http\Controllers\AuditController::class, 'search']) }}>{{ html()->img(asset('images/search.png'), 'New search')->attribute('title', "New search")->class('btn btn-link') }}</a></span>
                </h1>
            </div>
            @if ($audits->isEmpty())
            <p>Oops, no known audits with the given search criteria</p>
            @else
            <table class="table table-striped table-bordered table-hover">
                <caption>
                    <h2>Audits</h2>
                </caption>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Model:ID</th>
                        <th>Action</th>
                        <th>Values</th>
                        <th>URL</th>
                        <th>Tags</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($audits as $audit)
                    <tr>
                        <td><a href="{{ URL('admin/audit/'. $audit->id) }}">{{ date('M d, Y g:i A', strtotime($audit->created_at)) }}</a></td>
                        <td>{{ $audit->user_name }} </td>
                        <td>{{ $audit->auditable_type . ":" . $audit->auditable_id }} </td>
                        <td>{{ $audit->event }}</td>
                        <td>
                            <div>
                                <span class="font-weight-bold">Old values: </span><br>
                                @if (isset($audit->old_values))
                                @foreach ($audit->old_values as $field=>$value)
                                        {{ $field }}: {{ $value }} /
                                    @endforeach
                                @endIf
                            </div>
                            <div class = "bg-success">
                                <span class="font-weight-bold">New values: </span><br>
                                    @if (isset($audit->new_values))
                                        @foreach ($audit->new_values as $field=>$value)
                                            {{ $field }}: {{ $value }} /
                                        @endforeach
                                    @endIf
                            </div>
                        </td>
                        <td>{{ $audit->url }}</td>
                        <td>{{ $audit->tags }}</td>
                    </tr>
                    @endforeach
                    {{ $audits->links() }}
                </tbody>
            </table>
            @endif
        </div>
    </div>
</section>
@stop
