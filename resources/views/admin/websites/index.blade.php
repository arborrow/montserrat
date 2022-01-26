@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Websites
            @can('create-website')
                <span class="options">
                    <a href={{ action([\App\Http\Controllers\WebsiteController::class, 'create']) }}>
                        <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
        <p class="lead">{{$websites->total()}} records</p>

    </div>
    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($websites->isEmpty())
            <div class="col-lg-12 text-center py-5">
                <p>It is a brand new world, there are no units of measure!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Website type</th>
                        <th scope="col">URL</th>
                        <th scope="col">Description</th>
                        <th scope="col">Contact ID</th>
                        <th scope="col">Asset ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($websites as $website)
                    <tr>
                        <td><a href="{{URL('admin/website/'.$website->id)}}">{{ $website->website_type }}</a></td>
                        <td><a href="{{$website->url}}">{{ $website->url }}</a></td>
                        <td>{{ $website->description }}</td>
                        <td>{{ $website->contact_id }}</td>
                        <td>{{ $website->asset_id }}</td>
                    </tr>
                    @endforeach
                    {{ $websites->links() }}
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
