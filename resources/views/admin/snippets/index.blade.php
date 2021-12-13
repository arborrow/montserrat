@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Snippets
            @can('create-snippet')
            <span class="options">
                <a href={{ action('SnippetController@create') }}>
                    <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                </a>
            </span>
            @endCan
            <span class="options">
                <a href={{ action('SnippetController@test') }} class="btn btn-light">
                    Test snippets
                </a>
            </span>
        </h2>
    </div>
    <div class="col-md-3 col-lg-6">
        <select class="type-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="">Filter by title ...</option>
            <option value="{{url('admin/snippet')}}">All titles</option>
            @foreach($titles as $key=>$title)
            <option value="{{url('admin/snippet/title/'.$key)}}">{{$title}}</option>
            @endForeach
        </select>
    </div>
    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($snippets->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>It is a brand new world, there are no snippets!</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Title - Label</th>
                    <th scope="col">Language</th>
                    <th scope="col">Snippet</th>
                </tr>
            </thead>
            <tbody>
                @foreach($snippets as $snippet)
                <tr>
                    <td><a href="{{URL('admin/snippet/'.$snippet->id)}}">{{ $snippet->title }} - {{ $snippet->label }}</a></td>
                    <td>{{ $snippet->language_label }}</td>
                    <td>{{ html_entity_decode($snippet->snippet,ENT_QUOTES | ENT_XML1) }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
