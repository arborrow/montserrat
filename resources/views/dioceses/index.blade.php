@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Diocese
            @can('create-contact')
                <span class="options">
                    <a href={{ action([\App\Http\Controllers\DioceseController::class, 'create']) }}>
                        {{ html()->img(asset('images/create.png'), 'Create Diocese')->attribute('title', "Create Diocese")->class('btn btn-light') }}
                    </a>
                </span>
            @endCan
        </h1>
        <p class="lead">{{$dioceses->total()}} records</p>
    </div>
    <div class="col-lg-12">
        @if ($dioceses->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>No Dioceses are currently in the database.</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th scope="col">Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Bishop</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone(s)</th>
                    <th scope="col">Email(s)</th>
                    <th scope="col">Website(s)</th>
               </tr>
            </thead>
            <tbody>
               @foreach($dioceses as $diocese)
                <tr>
                    <td scope="row">{!!$diocese->avatar_small_link!!}</td>
                    <td><a href="diocese/{{$diocese->id}}">{{ $diocese->organization_name }}</a></td>
                    <td>
                        @if ($diocese->bishops->isEmpty())
                           <p>No Bishop(s) assigned</p>
                        @else
                            @foreach($diocese->bishops as $bishop)
                                <a href="person/{{$bishop->contact_id_b}}">{{ $bishop->contact_b->full_name}}</a>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @foreach($diocese->addresses as $address)
                            @if ($address->is_primary)
                                {!!$address->google_map!!}
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($diocese->phones as $phone)
                            @if (($phone->location_type_id==3) and ($phone->phone_type=="Phone"))
                                <a href="tel:{{ $phone->phone }}"> {{ $phone->phone }}</a>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($diocese->emails as $email)
                            @if ($email->is_primary)
                                <a href="mailto:{{ $email->email }}">{{ $email->email }}</a>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($diocese->websites as $website)
                            @if(!empty($website->url))
                                <a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                            @endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
                {{ $dioceses->links() }}
            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
