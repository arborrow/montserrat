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
    <div class="col-lg-12 my-3 table-responsive-md">
        @if ($gift_certificates->isEmpty())
        <div class="col-lg-12 text-center py-5">
            <p>It is a brand new world, there are no gift certicates!</p>
        </div>
        @else
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Certificate #</th>
                    <th scope="col">Purchaser</th>
                    <th scope="col">Recipient</th>
                    <th scope="col">Expires</th>
                    <th scope="col">Funded</th>
                    <th scope="col">Comments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gift_certificates as $gift_certificate)
                <tr>
                    <td><a href="{{url('/gift_certificate/'.$gift_certificate->id)}}">
                        {{ $gift_certificate->certificate_number}}
                    </a></td>
                    <td>{!! $gift_certificate->purchaser->contact_link !!}</td>
                    <td>{!! optional($gift_certificate->recipient)->contact_link !!}</td>
                    <td>{{ $gift_certificate->expiration_date->format('m-d-Y') }}</td>
                    <td> ${{ $gift_certificate->formatted_funded_amount }}</td>
                    <td>{{ $gift_certificate->notes }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
