@extends('template')
@section('content')

<h1>Welcome to the Finance Page</h1>

@can('show-donation')

    {{ html()->a(action([\App\Http\Controllers\DonationController::class, 'index']),'Donations')
        ->class('m-2 btn btn-outline-dark')
    }}
    
    {{ html()->a(action([\App\Http\Controllers\PaymentController::class, 'index']),'Payments')
        ->class('m-2 btn btn-outline-dark')
    }}

    @can('show-squarespace-contribution')
        {{ html()->a(action([\App\Http\Controllers\SquarespaceContributionController::class, 'index']),'Squarespace Contributions')
            ->class('m-2 btn btn-outline-dark')
        }}
    @endcan

    @can('show-stripe-payout')
        {{ html()->a(action([\App\Http\Controllers\StripePayoutController::class, 'index']),'Stripe Payouts')
            ->class('m-2 btn btn-outline-dark')
        }}
    @endCan

    <hr />
    
    <h2>Finance reports</h2>
    
    <div class="row bg-cover">
        <div class="col-lg-2 col-md-4">
            <h5>AGC Reports</h5>
            {{ html()->a(action([\App\Http\Controllers\DonationController::class, 'agc'],$current_fiscal_year),'AGC FY'.$current_fiscal_year)
                ->class('m-2 btn btn-outline-dark')
            }}
            
            {{ html()->a(action([\App\Http\Controllers\DonationController::class, 'agc'],$current_fiscal_year-1),'AGC FY'.$current_fiscal_year-1)
                ->class('m-2 btn btn-outline-dark')
            }}

        </div>
    
        <div class="col-lg-2 col-md-4">
            <h5>Bank Reports</h5>
            {{ html()->a(action([\App\Http\Controllers\PageController::class, 'finance_cash_deposit'],now()->format('Ymd')),'Cash/Check bank deposit report')
                ->class('m-2 btn btn-outline-dark')
            }}
            
            {{ html()->a(action([\App\Http\Controllers\PageController::class, 'finance_cc_deposit'],now()->format('Ymd')),'Credit Card (Internet) bank deposit report')
                ->class('m-2 btn btn-outline-dark')
            }}
        </div>
    
        <div class="col-lg-2 col-md-4">       
            <h5>Deposit Reports</h5>
            
                {{ html()->a(action([\App\Http\Controllers\PageController::class, 'finance_deposits']),'Retreat deposits report')
                    ->class('m-2 btn btn-outline-dark')
                }}
                {{ html()->a(action([\App\Http\Controllers\PageController::class, 'finance_reconcile_deposit_show']),'Unreconciled open deposits')
                    ->class('m-2 btn btn-outline-dark')
                }}
        </div>
            
        <div class="col-lg-2 col-md-4">         
            <h5>Donation Reports</h5>
            
                {{ html()->a(action([\App\Http\Controllers\PageController::class, 'finance_retreatdonations'],'201601'),'Retreat donation report')
                    ->class('m-2 btn btn-outline-dark')
                }}
                {{ html()->a(action([\App\Http\Controllers\DonationController::class, 'overpaid']),'Overpaid donations')
                    ->class('m-2 btn btn-outline-dark')
                }}
        </div>
            
        <div class="col-lg-2 col-md-4">         
            <h5>Other Reports</h5>
     
                {{ html()->a(action([\App\Http\Controllers\DonationController::class, 'mergeable']),'Mergeable Donations',)
                    ->class('m-2 btn btn-outline-dark')
                }}

        </div>
    </div>
@endCan

@stop