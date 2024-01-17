@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        @can('update-donation-type')
        <h1>
            Donation type details: <strong><a href="{{url('admin/donation_type/'.$donation_type->id.'/edit')}}">{{ $donation_type->label }}</a></strong>
        </h1>
        @else
        <h1>
            Donation type details: <strong>{{$donation_type->label}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-lg-12">
        <span class="font-weight-bold">Label: </span> {{$donation_type->label}}<br />
        <span class="font-weight-bold">Value: </span> {{$donation_type->value}}<br />
        <span class="font-weight-bold">Name: </span> {{$donation_type->name}}<br />
        <span class="font-weight-bold">Description: </span> {{$donation_type->description}}<br />
        <span class="font-weight-bold">Active: </span>{{$donation_type->is_active ? 'Yes':'No'}}

    </div>
    <br />

    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-donation-type')
                    <a href="{{ action([\App\Http\Controllers\DonationTypeController::class, 'edit'], $donation_type->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-donation-type')
                    {{ html()->form('DELETE', route('donation_type.destroy', [$donation_type->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                    {{ html()->form()->close() }}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
