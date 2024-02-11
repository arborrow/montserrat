@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Vendors
            @can('create-contact')
                <span class="options">
                    <a href={{ action([\App\Http\Controllers\VendorController::class, 'create']) }}>
                        {{ html()->img(asset('images/create.png'), 'Create Vendor')->attribute('title', "Create Vendor")->class('btn btn-light') }}
                    </a>
                </span>
            @endCan
        </h1>
        <p class="lead">{{$vendors->total()}} records</p>
    </div>
    <div class="col-lg-12">
    @if ($vendors->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>No vendors are currently in the database.</p>
        </div>
    @else
    <table class="table table-bordered table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th scope="col">Picture</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col">Webpage</th>
           </tr>
        </thead>
        <tbody>
            @foreach($vendors as $vendor)
            <tr>
                <th scope="row">{!!$vendor->avatar_small_link!!}</th>
                <td><a href="vendor/{{$vendor->id}}">{{ $vendor->organization_name }} </a></td>
                <td>
                    @foreach($vendor->addresses as $address)
                    @if ($address->is_primary)
                        {!!$address->google_map!!}
                    @endif
                    @endforeach
                </td>
                <td>
                    @foreach($vendor->phones as $phone)
                    @if (($phone->location_type_id==3) and ($phone->phone_type=="Phone"))
                    <a href="tel:{{ $phone->phone }}"> {{ $phone->phone }}</a>
                    @endif
                    @endforeach
                </td>
                <td>
                    @foreach($vendor->emails as $email)
                    @if ($email->is_primary)
                    <a href="mailto:{{ $email->email }}">{{ $email->email }}</a>
                    @endif
                    @endforeach
                </td>
                <td>

                    @foreach($vendor->websites as $website)
                     @if(!empty($website->url))
                    <a href="{{$website->url}}" target="_blank">{{$website->url}}</a><br />
                    @endif
                    @endforeach

                </td>
            </tr>
            @endforeach
          {!!$vendors->links()!!}
        </tbody>
    </table>
    @endif
    </div>
</div>
@stop
