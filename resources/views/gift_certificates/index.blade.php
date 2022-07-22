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
                    <th scope="col">Scheduled</th>
                    <th scope="col">Assigned</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gift_certificates as $gift_certificate)
                <tr>
                    <td><a href="{{URL('gift_certificate/'.$gift_certificate->id)}}">{{ $gift_certificate->scheduled_date }}</a></td>
                    <td><a href="{{$gift_certificate->assigned_contact_url}}">{{ $gift_certificate->assigned_sort_name }}</a></td>
                    <td>{{ $gift_certificate->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@stop
