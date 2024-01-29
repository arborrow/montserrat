@extends('template')
@section('content')


<div class="jumbotron text-left">
    <span><h2><strong>Edit Attachment:</strong></h2></span>

    {{ html()->form('PUT', route('attachment.update', [$attachment->id]))->open() }}
    {{ html()->hidden('id', $attachment->id) }}

        <span><h2>Attachment details for {{ $attachment->uri }}</h2>
            <div class="form-group">
                <div class='row'>
                    {{ html()->label('Description:', 'description') }}
                    {{ html()->textarea('description', $attachment->description)->class('form-control') }}
                </div>
                <div class="form-group">

                Entity: {!!$attachment->entity_link!!}<br />

                Mime Type: {{$attachment->mime_type}}<br />
                Upload date: {{$attachment->upload_date}}<br />

                </div>


                <div class="clearfix"> </div>

            </div>
        </span>

    <div class="clearfix"> </div>
    <div class="form-group">
        {{ html()->input('image', 'btnSave')->class('btn btn-primary')->attribute('src', asset('images/save.png')) }}
    </div>
    {{ html()->form()->close() }}
</div>
@stop
