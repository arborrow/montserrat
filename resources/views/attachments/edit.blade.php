@extends('template')
@section('content')


<div class="jumbotron text-left">
    <span><h2><strong>Edit Attachment:</strong></h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['attachment.update', $attachment->id]]) !!}
    {!! Form::hidden('id', $attachment->id) !!}

        <span><h2>Attachment details for {{ $attachment->uri }}</h2>
            <div class="form-group">
                <div class='row'>
                    {!! Form::label('description', 'Description:')  !!}
                    {!! Form::textarea('description', $attachment->description, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">

                Entity: {{$attachment->entity}}<br />
                Entity ID: {{$attachment->entity_id}}<br />

                Mime Type: {{$attachment->mime_type}}<br />
                Upload date: {{$attachment->upload_date}}<br />

                </div>


                <div class="clearfix"> </div>

            </div>
        </span>

    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop
