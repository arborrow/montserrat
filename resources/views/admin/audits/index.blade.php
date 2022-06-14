@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Audits
        </h2>
    </div>
    <span>{{ $audits->links() }}</span>
    <div class="col-md-3 col-lg-6">
        <select class="type-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="">Filter by user ...</option>
            <option value="{{url('admin.audit')}}">All audits</option>
            @foreach($users as $key=>$user_id)
            <option value="{{url('admin/audit/user/'.$key)}}">{{$user_id}}</option>
            @endForeach
        </select>
    </div>

    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($audits->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>It is a brand new world, there are no audits!</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">User</th>
                    <th scope="col">URL</th>
                    <th scope="col">Action/Entity</th>
                    <th scope="col" style="width:25%">Old</th>
                    <th scope="col" style="width:25%">New</th>
                </tr>
            </thead>
            <tbody>
                @foreach($audits as $audit)
                <tr>
                    <td><a href="{{URL('admin/audit/'.$audit->id)}}">{{ $audit->created_at }}</a></td>
                    <td>{{ $audit->user_name }}</td>
                    <td><a href="{{ URL($audit->url) }}">{{ $audit->url }}</a></td>
                    <td>{{ $audit->event }} {{ $audit->auditable_type }}:{{ $audit->auditable_id }}</td>
                    <td>{{ json_encode($audit->old_values, JSON_PRETTY_PRINT) }}</td>
                    <td>{{ json_encode($audit->new_values, JSON_PRETTY_PRINT) }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
