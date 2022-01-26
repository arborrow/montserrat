@extends('template')
@section('content')
    <div class="row bg-cover">
        <div class="col-lg-12">
            <h1>
                Parish
                @can('create-contact')
                <span class="options">
                    <a href={{ action([\App\Http\Controllers\ParishController::class, 'create']) }}>
                        {!! Html::image('images/create.png', 'Create Parish',array('title'=>"Create Parish",'class' => 'btn btn-light')) !!}
                    </a>
                </span>
                @endCan
            </h1>
            <p class="lead">{{$parishes->count()}} parishes
                @if($diocese !== NULL && $diocese->organization_name !== NULL)
                    in {{ $diocese->organization_name }}
                @endIf
            </p>
            @if ($dioceses->isEmpty())
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option value="">Filter by Diocese ...</option>
                            <option value="{{url('parish')}}">All Dioceses</option>
                        </select>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <select class="custom-select" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                            <option value="">Filter by Diocese ...</option>
                            <option value="{{url('parish')}}">All Dioceses</option>
                            @foreach($dioceses as $d)
                                <option value="{{url('parishes/diocese/'.$d->id)}}">{{$d->sort_name}}</option>
                            @endForeach
                        </select>
                    </div>
                </div>
            @endIf

        </div>
        <div class="col-lg-12">
            @if ($parishes->isEmpty())
            <div class="col-lg-12 text-center py-5">
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
                        <td><a href="{{URL('parish/'.$parish->id)}}">{{ $parish->organization_name }} </a></td>
                        <td><a href="{{URL('diocese/'.$parish->diocese_id)}}">{{ $parish->diocese_name }}</a></td>
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
