@extends('template')
@section('content')

<div class="row">
    <div class="col-12">
        <h2>
            Persons
            @can('create-contact')
            <span class="create">
                <a href={{ action('PersonController@create') }}>
                    <img src="images/create.png" alt="Add" class="btn btn-light" title="Add">
                </a>
            </span>
            @endCan
        </h2>
        <p class="lead">{{$persons->total()}} records</p>
    </div>
    <div class="col-12 my-2">
        <div class="filters">
            <span>
                <a href={{ action('PersonController@boardmembers') }}>
                    <img src="images/board.png" class="btn btn-info" alt="Board Members" title="Board Members">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@captains') }}>
                    <img src="images/captain.png" alt="Captains" class="btn btn-info" title="Captains">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@staff') }}>
                    <img src="images/employee.png" alt="Employees" class="btn btn-info" title="Employees">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@stewards') }}>
                    <img src="images/steward.png" alt="Stewards" class="btn btn-info" title="Stewards">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@volunteers') }}>
                    <img src="images/volunteer.png" alt="Volunteers" class="btn btn-info" title="Volunteers">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@directors') }}>
                    <img src="images/director.png" alt="Directors" class="btn btn-info" title="Directors">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@innkeepers') }}>
                    <img src="images/innkeeper.png" alt="Innkeepers" class="btn btn-info" title="Innkeepers">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@assistants') }}>
                    <img src="images/assistant.png" alt="Assistants" class="btn btn-info" title="Assistants">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@bishops') }}>
                    <img src="images/bishop.png" alt="Bishops" class="btn btn-info" title="Bishops">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@pastors') }}>
                    <img src="images/pastor.png" alt="Pastor" class="btn btn-info" title="Pastor">
                </a>
            </span>
            <span class="priests">
                <a href={{ action('PersonController@priests') }}>
                    <img src="images/priest.png" alt="Priests" class="btn btn-info" title="Priests">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@deacons') }}>
                    <img src="images/deacon.png" alt="Deacons" class="btn btn-info" title="Deacons">
                </a>
            </span>
            <span class="provincials">
                <a href={{ action('PersonController@provincials') }}>
                    <img src="images/provincial.png" alt="Provincials" class="btn btn-info" title="Provincials">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@superiors') }}>
                    <img src="images/superior.png" alt="Superiors" class="btn btn-info" title="Superiors">
                </a>
            </span>
            <span>
                <a href={{ action('PersonController@jesuits') }}>
                    <img src="images/jesuit.png" alt="Jesuits" class="btn btn-info" title="Jesuits">
                </a>
            </span>
        </div>
    </div>
    <div class="col-12">
        @if ($persons->isEmpty())
            <p>It is a brand new world, there are no persons. Let there be light!</p>
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
                            <div class="alert alert-warning"><strong>Do Not Mail</strong></div>
                            @endIf
                            {!!$person->address_primary_google_map!!}
                        </td>
                        <td>
                            @if($person->do_not_phone)
                            <div class="alert alert-warning"><strong>Do Not Call</strong></div>
                            @endIf
                            @if($person->do_not_sms)
                            <div class="alert alert-warning"><strong>Do Not Text</strong></div>
                            @endIf
                            @foreach($person->phones as $phone)
                            @if (($phone->location_type_id==1) and ($phone->phone_type=="Phone"))
                            <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                            @endif
                            @endforeach

                        <td>

                            @if($person->do_not_phone)
                            <div class="alert alert-warning"><strong>Do Not Call</strong></div>
                            @endIf
                            @if($person->do_not_sms)
                            <div class="alert alert-warning"><strong>Do Not Text</strong></div>
                            @endIf
                            @foreach($person->phones as $phone)
                            @if (($phone->location_type_id==1) and ($phone->phone_type=="Mobile"))
                            <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                            @endif
                            @endforeach
                        </td>
                        <td>

                            @if($person->do_not_email)
                            <div class="alert alert-warning"><strong>Do Not Email</strong></div>
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
                    {!! $persons->render() !!}
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop