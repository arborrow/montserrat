@extends('template')
@section('content')
<h1>Welcome to the Finance Page</h1>
@can('show-donation')
    {!! Html::link(action([\App\Http\Controllers\DonationController::class, 'index']),'Donations',array('class' => 'btn btn-outline-dark'))!!}
    {!! Html::link(action([\App\Http\Controllers\PaymentController::class, 'index']),'Payments',array('class' => 'btn btn-outline-dark'))!!}
    <hr />
    <div class="row bg-cover">
        <div class="col-lg-4 col-md-6">
          <h2>Finance reports</h2>

          <ul class="list-group">
            <li class="list-group-item"><h5>AGC Reports</h5></li>
              <ul>
                <li>{!! Html::link(action([\App\Http\Controllers\DonationController::class, 'agc'],2022),'AGC FY22',array('class' => 'list-group-item'))!!}
              </ul>
            <li class="list-group-item"><h5>Bank Reports</h5></li>
            <ul>
              <li>{!! Html::link(action([\App\Http\Controllers\PageController::class, 'finance_cash_deposit'],now()->format('Ymd')),'Cash/Check bank deposit report',array('class' => 'list-group-item'))!!}</li>
              <li>{!! Html::link(action([\App\Http\Controllers\PageController::class, 'finance_cc_deposit'],now()->format('Ymd')),'Credit Card (Internet) bank deposit report',array('class' => 'list-group-item'))!!}</li>
            </ul>
            <li class="list-group-item"><h5>Deposit Reports</h5></li>
              <ul>
                <li>{!! Html::link(action([\App\Http\Controllers\PageController::class, 'finance_deposits']),'Retreat deposits report',array('class' => 'list-group-item'))!!}</li>
                <li>{!! Html::link(action([\App\Http\Controllers\PageController::class, 'finance_reconcile_deposit_show']),'Unreconciled open deposits',array('class' => 'list-group-item'))!!}</li>
            </ul>
            <li class="list-group-item"><h5>Donation Reports</h5></li>
            <ul>
              <li>{!! Html::link(action([\App\Http\Controllers\PageController::class, 'finance_retreatdonations'],'201601'),'Retreat donation report',array('class' => 'list-group-item'))!!}</li>
              <li>{!! Html::link(action([\App\Http\Controllers\DonationController::class, 'overpaid']),'Overpaid donations',array('class' => 'list-group-item'))!!}</li>
            </ul>
            <li class="list-group-item"><h5>Other Reports</h5></li>
            <ul>
              <li>{!! Html::link(action([\App\Http\Controllers\PersonController::class, 'duplicates']),'Duplicate contacts report',array('class' => 'list-group-item'))!!}</li>
            </ul>
          </ul>

        </div>
    </div>
@endCan

@stop
