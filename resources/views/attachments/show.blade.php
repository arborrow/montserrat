@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2><strong>Attachment details: 
                        @can('update-attachment')
                            {!! Html::link(url('attachment/'.$attachment->id.'/edit'),$attachment->uri) !!}
                        @else
                            {{$attachment->uri}}
                        @endCan
                        </strong></h2>
                </span>
            </div>
            <div class="clearfix"> </div>

            <div class='row'>
                <div class='col-md-4'>
                        <strong>Filename: </strong>{{$attachment->uri}}
                        <br /><strong>Description: </strong>{{$attachment->description}}
                        <br /><strong>Mime Type: </strong>{{$attachment->mime_type}}
                        <br /><strong>Entity: </strong>{!!$attachment->entity_link!!}
                        <br /><strong>Upload date: </strong>{{$attachment->upload_date}}
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>

        <div class='row'>
            @can('update-attachment')
                <div class='col-md-1'>
                    <a href="{{ action([\App\Http\Controllers\AttachmentController::class, 'edit'], $attachment->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                </div>
            @endCan
            <div class="clearfix"> </div>
        </div>
    </div>
</section>
@stop
