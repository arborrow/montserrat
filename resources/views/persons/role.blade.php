@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            {{$role['name']}}
            @can('create-contact')
                <span class="create">
                    <a href={{ action([\App\Http\Controllers\PersonController::class, 'create']) }}>
                        <img src="{{URL::asset('images/create.png')}}" alt="Add" class="btn btn-light" title="Add">
                    </a>
                </span>
            @endCan
        </h2>
        <p class="lead">
            {{$persons->count()}} records
        </p>
    </div>
    <div class="col-lg-12">
        @can('show-contact')
            <span class="person">
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'index']) }} class="btn btn-light">
                    {{ html()->img(asset('images/person.png'), 'Show Persons')->attribute('title', "Show Persons") }}
                </a>
            </span>
        @if(isset($role['email_link']))
            <span class="btn btn-link">{!! $role['email_link'] !!}</span>
        @endif
        @endCan
        @can('create-registration')
            <a href={{ action([\App\Http\Controllers\RegistrationController::class, 'add_group'],$role['group_id']) }} class="btn btn-link">Add Group Registration</a>
        @endCan
        @can('create-touchpoint')
            <a href={{ action([\App\Http\Controllers\TouchpointController::class, 'add_group'],$role['group_id']) }} class="btn btn-link">Add Group Touchpoint</a>
        @endCan
    </div>
    <div class="col-lg-12">
        @if ($persons->isEmpty())
            <div class="col-lg-12 text-center py-5">
                <h3>Currently, there are no {{$role['name']}}s.</h3>
            </div>
        @else
            <table class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Picture</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address (City)</th>
                        <th scope="col">Home phone</th>
                        <th scope="col">Cell phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Parish (City)</th>
                        @if ($role['group_id'] == config('polanco.group_id.ambassador'))
                            <th scope="col">Ambassador for</th>
                        @endIf
                    </tr>
                </thead>
                <tbody>
                    @foreach($persons as $person)
                    <tr>
                        <th scope="row">{!!$person->avatar_small_link!!}</th>
                        <td>
                            {!!$person->contact_link_full_name!!}
                        </td>
                        <td>
                            {!!$person->address_primary_google_map!!}
                        </td>
                        <td><a href="tel:{{ $person->phone_home_phone_number }}">{{ $person->phone_home_phone_number }}</a></td>
                        <td><a href="tel:{{ $person->phone_home_mobile_number }}">{{ $person->phone_home_mobile_number }}</a></td>
                        <td><a href="mailto:{{$person->email_primary_text}}">{{ $person->email_primary_text }}</a></td>
                        <td>{!! $person->parish_link !!}</td>
                        @if ($role['group_id'] == config('polanco.group_id.ambassador'))
                        <td>
                            <ul>
                                @foreach ($person->ambassador_events as $participant)
                                    <li>
                                      {!! $participant->event_link !!}
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
@stop
