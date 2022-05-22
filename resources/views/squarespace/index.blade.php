@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">SquareSpace Donations and Orders</span>
                    </h1>
                        <a class='btn btn-primary' href="{{ action([\App\Http\Controllers\SquarespaceDonationController::class, 'index']) }}">
                           Donations
                        </a>
                        <a class='btn btn-primary' href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'index']) }}">
                           Orders
                        </a>
                </div>
            </div>
        </div>
    </section>
@stop
