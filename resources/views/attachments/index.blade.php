@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>
            Attachments
        </h2>
    </div>
    <div class="col-12 my-3 table-responsive-md">
        @if ($attachments->isEmpty())
            <div class="col-12 text-center py-5">
                <p>It is a brand new world, there are no attachments!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Filename</th>
                        <th scope="col">Description</th>
                        <th scope="col">Entity ID</th>
                        <th scope="col">Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attachments as $attachment)
                    <tr>
                        <td><a href = "{{ URL('/attachment/'.$attachment->id) }}">{{ $attachment->id }}</a></td>
                        <td>{{ $attachment->uri}}</td>
                        <td>{{ $attachment->description }}</td>
                        <td>{!! $attachment->entity_link !!}</td>
                        <td>{{ $attachment->upload_date }}</td>
                    </tr>
                    @endforeach
                    {{ $attachments->links() }}
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
