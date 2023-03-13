@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            Gift Certificates
            @can('create-gift-certificate')
            <span class="options">
                <a href={{ action([\App\Http\Controllers\GiftCertificateController::class, 'create']) }}>
                    <img src="{{ URL::asset('images/create.png') }}" alt="Add" class="btn btn-light" title="Add">
                </a>
            </span>
            @endCan
        </h2>
    </div>
<div class="col-lg-12 m-2 p-2">
    <ul role="tablist" class="nav nav-tabs">
        <li class="nav-item" role="tab">
            <a class="nav-link active" data-toggle="tab" role="tab" href="#active">
                <i class="fa fa-lock-open"></i>
                <label>Active ({{$gift_certificates->count()}})</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#applied">
                <i class="fa fa-lock"></i>
                <label>Applied ({{$applied_gift_certificates->count()}})</label>
            </a>
        </li>
        <li class="nav-item" role="tab">
            <a class="nav-link" data-toggle="tab" role="tab" href="#expired">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                <label>Expired ({{$expired_gift_certificates->count()}})</label>
            </a>
        </li>
    </ul>

    <div class="tab-content border border-secondary" id="myTabContent">
        <div aria-labelledby="tab1-tab" id="active" class="tab-pane fade show active" role="tabpanel">
                @if ($gift_certificates->isEmpty())
                    <div class="col-lg-12 my-3 table-responsive-md">
                        <div class="text-center py-5">
                            <p>Currently, there are no active gift certificates</p>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 my-3 table-responsive-md">
                        <table class="table table-striped table-bordered table-hover">
                            <caption class="text-secondary font-weight-bold">Active Gift Certificates</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Certificate #</th>
                                    <th scope="col">Purchaser</th>
                                    <th scope="col">Recipient</th>
                                    <th scope="col">Purchased / Expires</th>
                                    <th scope="col">Funded</th>
                                    <th scope="col">Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gift_certificates as $active)
                                <tr>
                                    <td><a href="{{url('/gift_certificate/'.$active->id)}}">
                                        {{ $active->certificate_number}}
                                    </a></td>
                                    <td>{!! $active->purchaser->contact_link !!}</td>
                                    <td>{!! $active->recipient?->contact_link !!}</td>
                                    <td>{{ $active->purchase_date->format('m-d-Y') }} / {{ $active->expiration_date->format('m-d-Y') }}</td>
                                    <td> ${{ $active->formatted_funded_amount }}</td>
                                    <td>{{ $active->notes }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
        </div>
        <div aria-labelledby="tab2-tab" id="applied" class="tab-pane fade" role="tabpanel">
            @if ($applied_gift_certificates->isEmpty())
                <div class="col-lg-12 my-3 table-responsive-md">
                    <div class="text-center py-5">
                        <p>Currently, there are no applied gift certificates</p>
                    </div>
                </div>
            @else
                <div class="col-lg-12 my-3 table-responsive-md">
                    <table class="table table-striped table-bordered table-hover">
                        <caption class="text-secondary font-weight-bold">Applied Gift Certificates</caption>
                        <thead>
                            <tr>
                                <th scope="col">Certificate #</th>
                                <th scope="col">Purchaser</th>
                                <th scope="col">Recipient</th>
                                <th scope="col">Purchased / Expires</th>
                                <th scope="col">Applied to</th>
                                <th scope="col">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applied_gift_certificates as $applied)
                            <tr>
                                <td><a href="{{url('/gift_certificate/'.$applied->id)}}">
                                    {{ $applied->certificate_number}}
                                </a></td>
                                <td>{!! $applied->purchaser->contact_link !!}</td>
                                <td>{!! $applied->recipient?->contact_link !!}</td>
                                <td>{{ $applied->purchase_date->format('m-d-Y') }} / {{ $applied->expiration_date->format('m-d-Y') }}</td>
                                <td> {!! $applied->registration->event_link !!}</td>
                                <td>{{ $applied->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div aria-labelledby="tab3-tab" id="expired" class="tab-pane fade" role="tabpanel">
            @if ($expired_gift_certificates->isEmpty())
                <div class="col-lg-12 my-3 table-responsive-md">
                    <div class="col-lg-12 text-center py-5">
                        <p>Currently, there are no (unapplied) expired gift certificates</p>
                    </div>
                </div>
            @else
                <div class="col-lg-12 my-3 table-responsive-md">
                    <table class="table table-striped table-bordered table-hover">
                    <caption class="text-secondary font-weight-bold">Expired Gift Certificates</caption>
                        <thead>
                            <tr>
                                <th scope="col">Certificate #</th>
                                <th scope="col">Purchaser</th>
                                <th scope="col">Recipient</th>
                                <th scope="col">Expired</th>
                                <th scope="col">Funded</th>
                                <th scope="col">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expired_gift_certificates as $expired)
                            <tr>
                                <td><a href="{{url('/gift_certificate/'.$expired->id)}}">
                                    {{ $expired->certificate_number}}
                                </a></td>
                                <td>{!! $expired->purchaser->contact_link !!}</td>
                                <td>{!! $expired->recipient?->contact_link !!}</td>
                                <td>{{ $expired->expiration_date->format('m-d-Y') }}</td>
                                <td> ${{ $expired->formatted_funded_amount }}</td>
                                <td>{{ $expired->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
@stop
