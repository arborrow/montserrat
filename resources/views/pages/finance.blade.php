@extends('template')
@section('content')

<h1>Welcome to the Finance Page</h1>

@can('show-donation')

    {!! Html::link(action([\App\Http\Controllers\DonationController::class, 'index']),'Donations',array('class' => 'btn
    btn-outline-dark'))!!}
    
    {!! Html::link(action([\App\Http\Controllers\PaymentController::class, 'index']),'Payments',array('class' => 'btn
    btn-outline-dark'))!!}

    @can('show-squarespace-contribution')
        {!! Html::link(action([\App\Http\Controllers\SquarespaceContributionController::class, 'index']),'Squarespace
        Contributions',array('class' => 'btn btn-outline-dark'))!!}
    @endcan

    @can('show-stripe-payout')
        {!! Html::link(action([\App\Http\Controllers\StripePayoutController::class, 'index']),'Stripe
        Payouts',array('class'
        => 'btn btn-outline-dark'))!!}
    @endCan

    <hr />
    
    <h2>Finance reports</h2>
    
    <div class="row bg-cover">
        <div class="col-lg-2 col-md-4">
            <h5>AGC Reports</h5>
            {!! Html::link(action([\App\Http\Controllers\DonationController::class, 'agc'],2022),'AGC
            FY22',array('class' => 'm-2 btn btn-secondary'))!!}
        </div>
    
        <div class="col-lg-2 col-md-4">
            <h5>Bank Reports</h5>
            {!! Html::link(action([\App\Http\Controllers\PageController::class,
            'finance_cash_deposit'],now()->format('Ymd')),'Cash/Check bank deposit report',array('class' =>
            'm-2 btn btn-secondary'))!!}
            
            {!! Html::link(action([\App\Http\Controllers\PageController::class,
                'finance_cc_deposit'],now()->format('Ymd')),'Credit Card (Internet) bank deposit report',array('class'
                =>
                'm-2 btn btn-secondary'))!!}
        </div>
    
        <div class="col-lg-2 col-md-4">       
            <h5>Deposit Reports</h5>
            
                {!! Html::link(action([\App\Http\Controllers\PageController::class, 'finance_deposits']),'Retreat
                    deposits
                    report',array('class' => 'm-2 btn btn-secondary'))!!}
                {!! Html::link(action([\App\Http\Controllers\PageController::class,
                    'finance_reconcile_deposit_show']),'Unreconciled open deposits',array('class' =>
                    'm-2 btn btn-secondary'))!!}
        </div>
            
        <div class="col-lg-2 col-md-4">         
            <h5>Donation Reports</h5>
            
                {!! Html::link(action([\App\Http\Controllers\PageController::class,
                    'finance_retreatdonations'],'201601'),'Retreat donation report',array('class' =>
                    'm-2 btn btn-secondary'))!!}
                {!! Html::link(action([\App\Http\Controllers\DonationController::class, 'overpaid']),'Overpaid
                    donations',array('class' => 'm-2 btn btn-secondary'))!!}
        </div>
            
        <div class="col-lg-2 col-md-4">         
            <h5>Other Reports</h5>
     
                {!! Html::link(action([\App\Http\Controllers\DonationController::class, 'mergeable']),'Mergeable Donations',
                array('class' => 'm-2 btn btn-secondary'))!!}

        </div>
    </div>
@endCan

@stop