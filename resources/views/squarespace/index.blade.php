@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">SquareSpace Contributions and Orders</span>
                    </h1>
                        <a class='btn btn-primary' href="{{ action([\App\Http\Controllers\SquarespaceContributionController::class, 'index']) }}">
                           Contributions
                        </a>
                        <a class='btn btn-primary' href="{{ action([\App\Http\Controllers\SquarespaceOrderController::class, 'index']) }}">
                           Orders
                        </a>
                </div>
            </div>
        </div>
    </section>
@stop
