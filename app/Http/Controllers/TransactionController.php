<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-donation');

        return view('transactions.index');
    }

    public function all(Request $request) 
    {
        $this->authorize('show-donation');

        $search = $request->input('search');
        $stripeConfig = config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($stripeConfig);
        $limit = 25;
        
        if ($request->has('limit'))
        {
            $limit = $request->input('limit');
        }

        $params = [ 'limit' => $limit];

        if ($request->has('id') && $request->has('direction'))
        {
            if ($request->input('direction') === 'next')
            {
                $params['starting_after'] = $request->input('id');
            }
            if ($request->input('direction') === 'previous')
            {
                $params['ending_before'] = $request->input('id');
            }
        }

        $transactions = $stripe->balanceTransactions->all($params);

        return response()->json($transactions);
    }
}
