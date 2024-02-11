@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Group Index</span>
                        @can('create-group')
                            <span class="create">
                                <a href="{{ action([\App\Http\Controllers\GroupController::class, 'create']) }}">
                                   {{ html()->img(asset('images/create.png'), 'Add Group')->attribute('title', "Add Group")->class('btn btn-primary') }}
                                </a>
                 
                            </span>
                        @endCan
                    </h1>
                </div>
                @if ($groups->isEmpty())
                    <p>It is a brand new world, there are no groups!</p>
                @else
                <table class="table table-bordered table-striped table-responsive"><caption><h2>Groups</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th># of Members</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                        <tr>
                            <td><a href="group/{{ $group->id }}">{{ $group->name }}</a></td>
                            <td>{{ $group->title }}</td>
                            <td>{{ $group->description }}</td>
                            <td>{{ $group->count }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop