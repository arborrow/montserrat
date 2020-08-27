@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <span class="grey">{{$assets->total()}} results found</span>
                    <span class="search"><a href={{ action('AssetController@search') }}>{!! Html::image('images/search.png', 'New search',array('title'=>"New search",'class' => 'btn btn-link')) !!}</a></span></h1>
            </div>
            @if ($assets->isEmpty())
            <p>Oops, no known assets with the given search criteria</p>
            @else
            <table class="table table-striped table-bordered table-hover">
                <caption>
                    <h2>Assets</h2>
                </caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th>Description</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                    <tr>
                        <td>
                            <a href="{{url('asset/'.$asset->id)}}">{{ $asset->name}}</a>
                        </td>
                        <td>{{$asset->manufacturer}}</td>
                        <td>{{$asset->model}}</td>
                        <td>{{$asset->description}}</td>
                        <td>{{$asset->location_name}}</td>
                    </tr>
                    @endforeach
                    {!! $assets->render() !!}
                </tbody>
            </table>
            @endif
        </div>
    </div>
</section>
@stop
