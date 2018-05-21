@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Roles Index</span> 
                    <span class="create"><a href={{ action('RoleController@create') }}>{!! Html::image('img/create.png', 'Add Role',array('title'=>"Add Role",'class' => 'btn btn-primary')) !!}</a></span></h1>
                
                </div>
                @if ($roles->isEmpty())
                    <p>It is a brand new world, there are no permissions!</p>
                @else
                <table class="table"><caption><h2>Roles</h2></caption>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Display name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td><a href="role/{{ $role->id}}">{{ $role->name }}</a></td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->description }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop