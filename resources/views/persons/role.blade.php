@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">{{$role['name']}} Index</span> 
                    <span class="grey">({{$persons->count()}} records)</span>
                    @can('create-contact')
                        <span class="create"><a href={{ action('PersonsController@create') }}>{!! Html::image('img/create.png', 'Add Person',array('title'=>"Add Person",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    @endCan
                    @can('show-contact')
                        <span class="person"><a href={{ action('PersonsController@index') }}>{!! Html::image('img/person.png', 'Show Persons',array('title'=>"Show Persons",'class' => 'btn btn-primary')) !!}</a></span></h1>
                    @if (isset($role['email_link']))
                        <span class="btn btn-default">{!! $role['email_link'] !!}</span>
                    @endif
                    @endCan
                    @can('create-registration')
                        <span class="btn btn-default">
                            <a href={{ action('RegistrationsController@add_group',$role['group_id']) }}>Add Group Registration</a>
                        </span>
                    @endCan
                    @can('create-touchpoint')
                    <span class="btn btn-default">
                        <a href={{ action('TouchpointController@add_group',$role['group_id']) }}>Add Group Touchpoint</a>
                    </span>
                    @endCan
                
            
                </div>
                @if ($persons->isEmpty())
                    <p>Currently, there are no {{$role['name']}}</p>
                @else
                <table class="table"><caption><h2>{{$role['name']}}</h2></caption>
                    <thead>
                        <tr>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Address (City)</th>
                            <th>Home phone</th>
                            <th>Cell phone</th>
                            <th>Work phone</th>
                            <th>Email</th>
                            <th>Parish (City)</th>
                            @if ($role['group_id'] == config('polanco.group_id.captain'))
                                <th>Captain for</th>
                            @endIf
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($persons as $person)
                        <tr>
                            <td>{!!$person->avatar_small_link!!}</td>
                            <td>
                                {!!$person->contact_link_full_name!!}
                            </td>
                            <td>
                                {!!$person->address_primary_google_map!!} 
                            </td>
                            <td>{{ $person->phone_home_phone_number }}</td>
                            <td>{{ $person->phone_home_mobile_number }}</td>
                            <td>{{ $person->phone_work_phone_number }}</td>
                            <td><a href="mailto:{{$person->email_primary_text}}">{{ $person->email_primary_text }}</a></td>
                            <td>{!! $person->parish_link !!}</td>
                            @if ($role['group_id'] == config('polanco.group_id.captain'))
                            <td>
                                <ul>
                                    @foreach ($person->captain_events as $event)
                                        <li>  
                                            <a href="{{url('retreat/'.$event->id)}}" title="{{$event->idnumber}}">{{$event->title}}</a>
                                        </li>
                                    @endforeach
                                </ul></td>
                            @endIf
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop