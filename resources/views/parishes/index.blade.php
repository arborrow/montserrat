@extends('template')
@section('content')
    <div class="row bg-cover">
        <div class="col-12">
            <h1>
                Parish
                @can('create-contact')
                <span class="options">
                    <a href={{ action('ParishController@create') }}>
                        {!! Html::image('images/create.png', 'Create Parish',array('title'=>"Create Parish",'class' => 'btn btn-light')) !!}
                    </a>
                </span>
                @endCan
            </h1>
            <p class="lead">{{$parishes->count()}} records</p>
        </div>
        <div class="col-12">
            <span class="btn btn-outline-dark">
                <a href={{ action('ParishController@dallasdiocese') }}>Diocese of Dallas</a>
            </span>
            <span class="btn btn-outline-dark">
                <a href={{ action('ParishController@fortworthdiocese') }}>Diocese of Fort Worth</a>
            </span>
            <span class="btn btn-outline-dark">
                <a href={{ action('ParishController@tylerdiocese') }}>Diocese of Tyler</a>
            </span>
        </div>
        <div class="col-12">
            @if ($parishes->isEmpty())
            <div class="col-12 text-center py-5">
                <p>No parishes are currently in the database.</p>
            </div>
            @else
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Diocese</th>
                        <th>Pastor</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Webpage</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($parishes as $parish)
                    <tr>
                        <td>{!!$parish->avatar_small_link!!}</td>
                        <td><a href="parish/{{$parish->id}}">{{ $parish->organization_name }} </a></td>
                        <td><a href="diocese/{{$parish->diocese_id}}">{{ $parish->diocese_name }}</a></td>
                        <td>
                            @if (empty($parish->pastor->contact_b))
                            No pastor assigned
                            @else
                            {!!$parish->pastor->contact_b->contact_link_full_name!!}
                            @endif
                        </td>
                        <td>
                            @foreach($parish->addresses as $address)
                            @if ($address->is_primary)
                                {!!$address->google_map!!}
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($parish->phones as $phone)
                            @if (($phone->location_type_id==3) and ($phone->phone_type=="Phone"))
                            <a href="tel:{{ $phone->phone }}"> {{ $phone->phone }}</a>
                            @endif
                            @endforeach
                        </td>
                        <td>

                            @foreach($parish->websites as $website)
                             @if(!empty($website->url))
                            <a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                            @endif
                            @endforeach

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            @endif
        </div>
    </div>
@stop
