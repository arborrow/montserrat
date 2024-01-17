@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-snippet')
        <h1>
            Snippet details: <strong><a href="{{url('admin/snippet/'.$snippet->id.'/edit')}}">{{ $snippet->title . ' - ' . $snippet->label }}</a></strong>
        </h1>
        @else
        <h1>
            Snippet details: <strong>{{$snippet->title}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <span class="font-weight-bold">Title: </span> {{$snippet->title}}<br />
        <span class="font-weight-bold">Label: </span> {{$snippet->label}}<br />
        <span class="font-weight-bold">Locale: </span> {{ $snippet->language_label }}<br />
        <span class="font-weight-bold">Snippet: </span> {{$snippet->snippet}}<br />
    </div>

    <br />

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-snippet')
                    <a href="{{ action([\App\Http\Controllers\SnippetController::class, 'edit'], $snippet->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-snippet')
                    {{ html()->form('DELETE', route('snippet.destroy', [$snippet->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                    {{ html()->form()->close() }}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
