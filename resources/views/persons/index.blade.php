@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Persons
            @can('create-contact')
                <span class="options">
                    <a href={{ action([\App\Http\Controllers\PersonController::class, 'create']) }}>
                        {!! Html::image('images/create.png', 'Create Person',array('title'=>"Create Person",'class' => 'btn btn-light')) !!}
                    </a>
                </span>
            @endCan
        </h1>
        <p class="lead">{{$persons->total()}} records</p>
    </div>
    <div class="col-lg-12 my-2">
        <div class="filters">
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'boardmembers']) }}>
                    <img src="{{ URL::asset('images/board.png')}}" class="btn btn-info" alt="Board Members" title="Board Members">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'ambassadors']) }}>
                    <img src="{{ URL::asset('images/ambassador.png') }}" alt="Ambassadors" class="btn btn-info" title="Ambassadors">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'staff']) }}>
                    <img src="{{ URL::asset('images/employee.png') }}" alt="Employees" class="btn btn-info" title="Employees">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'stewards']) }}>
                    <img src="{{ URL::asset('images/steward.png') }}" alt="Stewards" class="btn btn-info" title="Stewards">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'volunteers']) }}>
                    <img src="{{ URL::asset('images/volunteer.png') }}" alt="Volunteers" class="btn btn-info" title="Volunteers">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'directors']) }}>
                    <img src="{{ URL::asset('images/director.png') }}" alt="Directors" class="btn btn-info" title="Directors">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'innkeepers']) }}>
                    <img src="{{ URL::asset('images/innkeeper.png') }}" alt="Innkeepers" class="btn btn-info" title="Innkeepers">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'assistants']) }}>
                    <img src="{{ URL::asset('images/assistant.png') }}" alt="Assistants" class="btn btn-info" title="Assistants">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'bishops']) }}>
                    <img src="{{ URL::asset('images/bishop.png') }}" alt="Bishops" class="btn btn-info" title="Bishops">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'pastors']) }}>
                    <img src="{{ URL::asset('images/pastor.png') }}" alt="Pastor" class="btn btn-info" title="Pastor">
                </a>
            </span>
            <span class="priests">
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'priests']) }}>
                    <img src="{{ URL::asset('images/priest.png') }}" alt="Priests" class="btn btn-info" title="Priests">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'deacons']) }}>
                    <img src="{{ URL::asset('images/deacon.png') }}" alt="Deacons" class="btn btn-info" title="Deacons">
                </a>
            </span>
            <span class="provincials">
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'provincials']) }}>
                    <img src="{{ URL::asset('images/provincial.png') }}" alt="Provincials" class="btn btn-info" title="Provincials">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'superiors']) }}>
                    <img src="{{ URL::asset('images/superior.png') }}" alt="Superiors" class="btn btn-info" title="Superiors">
                </a>
            </span>
            <span>
                <a href={{ action([\App\Http\Controllers\PersonController::class, 'jesuits']) }}>
                    <img src="{{ URL::asset('images/jesuit.png') }}" alt="Jesuits" class="btn btn-info" title="Jesuits">
                </a>
            </span>
        </div>
    </div>
    <div class="col-lg-12 table-responsive-lg">
        @if ($persons->isEmpty())
            <div class="col-lg-12 text-center py-5">
                <p>It is a brand new world, there are no persons. Let there be light!</p>
            </div>
        @else
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Picture</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address (City)</th>
                        <th scope="col">Home phone</th>
                        <th scope="col">Cell phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Parish (City)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($persons as $person)
                    <tr>
                        <th scope="row">{!!$person->avatar_small_link!!}</th>
                        <td>{!!$person->contact_link_full_name!!}</td>
                        <td>
                            @if($person->do_not_mail)
                            <div class="alert alert-warning alert-important"><strong>Do Not Mail</strong></div>
                            @endIf
                            {!!$person->address_primary_google_map!!}
                        </td>
                        <td>
                            @if($person->do_not_phone)
                            <div class="alert alert-warning alert-important"><strong>Do Not Call</strong></div>
                            @endIf
                            @if($person->do_not_sms)
                            <div class="alert alert-warning alert-important"><strong>Do Not Text</strong></div>
                            @endIf
                            @foreach($person->phones as $phone)
                            @if (($phone->location_type_id==1) and ($phone->phone_type=="Phone"))
                            <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                            @endif
                            @endforeach

                        <td>

                            @if($person->do_not_phone)
                            <div class="alert alert-warning alert-important"><strong>Do Not Call</strong></div>
                            @endIf
                            @if($person->do_not_sms)
                            <div class="alert alert-warning alert-important"><strong>Do Not Text</strong></div>
                            @endIf
                            @foreach($person->phones as $phone)
                            @if (($phone->location_type_id==1) and ($phone->phone_type=="Mobile"))
                            <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                            @endif
                            @endforeach
                        </td>
                        <td>

                            @if($person->do_not_email)
                            <div class="alert alert-warning alert-important"><strong>Do Not Email</strong></div>
                            @endIf
                            @foreach($person->emails as $email)
                            @if ($email->is_primary)
                            <a href="mailto:{{ $email->email }}">{{ $email->email }}</a>
                            @endif
                            @endforeach
                        </td>
                        <td>
                            {!! $person->parish_link !!}
                        </td>
                    </tr>
                    @endforeach
                    {{ $persons->links() }}
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
