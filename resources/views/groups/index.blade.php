@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Group Index</span> 
                    <span class="create"><a href={{ action('GroupsController@create') }}>{!! Html::image('img/create.png', 'Add Group',array('title'=>"Add Group",'class' => 'btn btn-primary')) !!}</a></span></h1>
                
                </div>
                @if ($groups->isEmpty())
                    <p>It is a brand new world, there are no groups!</p>
                @else
                <table class="table"><caption><h2>Groups</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Active</th>
                            <th>Hidden</th>
                            <th>Reserved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                        <tr>
                            <td><a href="group/{{ $group->id }}">{{ $group->name }}</a></td>
                            <td>{{ $group->title }}</td>
                            <td>{{ $group->description }}</td>
                            <td>{{ $group->is_active }}</td>
                            <td>{{ $group->is_hidden }}</td>
                            <td>{{ $group->is_reserved }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop