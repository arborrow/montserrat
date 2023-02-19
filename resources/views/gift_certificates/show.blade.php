@extends('template')
@section('content')

<div class="row bg-cover" style="border:1px;">
    <div class="col-lg-12">

        @can('update-gift-certificate')
        
        <h1>
            Gift certificate <strong><a href="{{url('gift_certificate/'.$gift_certificate->id.'/edit')}}">#{{ $gift_certificate->certificate_number }}</a></strong>
        </h1>
        @else
        <h1>
            Gift certificate <strong>#{{$gift_certificate->id}}</strong>
        </h1>
        @endCan
    </div>

    <div class="col-lg-12">
        <div class="border  border-secondary m-2 p-2">
            <h3 class="text-secondary">Info</h3>
            <div class="row">
                <div class="col-lg-3"><strong>Certificate #:</strong> {{$gift_certificate->certificate_number}}</div>
                <div class="col-lg-2"><strong>Purchaser:</strong> {!!$gift_certificate->purchaser->contact_link!!}</div>
                <div class="col-lg-2"><strong>Recipient:</strong> {!!optional($gift_certificate->recipient)->contact_link!!}</div>
            </div>
        </div>
        <div class="border  border-secondary m-2 p-2">
            <h3 class="text-secondary">Dates</h3>
            <div class="row">
                <div class="col-lg-3"><strong>Purchased:</strong> {{$gift_certificate->purchase_date->format('m-d-Y')}}</div>
                <div class="col-lg-3"><strong>Issued:</strong> {{$gift_certificate->issue_date->format('m-d-Y')}}</div>
                <div class="col-lg-3"><strong>Expiration:</strong> {{$gift_certificate->expiration_date->format('m-d-Y')}}</div>
            </div>
        </div>
        <div class="border  border-secondary m-2 p-2">
            <h3 class="text-secondary">Funding</h3>
            <div class="row">
                <div class="col-lg-2"><strong>Funded amount:</strong> ${{$gift_certificate->formatted_funded_amount}}</div>
                <div class="col-lg-3"><strong>Donation ID:</strong> <a href={{url('/donation/'.$gift_certificate->donation_id)}}>{{$gift_certificate->donation_id}}</a></div>
                <div class="col-lg-3"><strong>Applied to:</strong> <a href={{url('/registration/'.$gift_certificate->participant_id)}}>{{optional($gift_certificate->registration)->event_name}}</a></div>
            </div>
        </div>
        <div class="border  border-secondary m-2 p-2">
            <h3 class="text-secondary">Notes</h3>
            <div class="row">
                <div class="col-lg-3"><strong>Notes:</strong> {{$gift_certificate->notes}}</div>
                <div class="col-lg-3"><strong>Retreat type:</strong> {{optional($gift_certificate->registration->retreat)->retreat_type}}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-asset')
                <a href="{{ action([\App\Http\Controllers\AssetJobController::class, 'edit'], $gift_certificate->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-asset')
                {!! Form::open(['method' => 'DELETE', 'route' => ['gift_certificate.destroy', $gift_certificate->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
