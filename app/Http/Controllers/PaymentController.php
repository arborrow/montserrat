<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentSearchRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[Authorize('show-payment')]
    public function index(): View
    {
        $payments = \App\Models\Payment::orderBy('payment_date', 'desc')->with('donation.retreat')->paginate(25, ['*'], 'payments');

        // dd($donations);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * Rather than complicating the interface by selecting a donation
     * I am choosing to require the donation_id to create a payment
     *
     * @return \Illuminate\Http\Response
     */
    public function create($donation_id = 0)
    {
        if ($donation_id > 0) {
            Gate::authorize('create-payment');
            $donation = \App\Models\Donation::findOrFail($donation_id);
            $payment_methods = config('polanco.payment_method');

            return view('payments.create', compact('donation', 'payment_methods'));
        } else {
            flash('Cannot create a payment without an associated Donation ID#')->error()->important();

            return Redirect::action([\App\Http\Controllers\DonationController::class, 'index']);
        }
    }

    #[Authorize('show-payment')]
    public function search(): View
    {
        $payment_methods = config('polanco.payment_method');
        $payment_methods[''] = 'N/A';

        $descriptions = \App\Models\DonationType::active()->orderby('name')->pluck('name', 'name');
        $descriptions->prepend('N/A', '');

        return view('payments.search', compact('payment_methods', 'descriptions'));
    }

    #[Authorize('show-payment')]
    public function results(PaymentSearchRequest $request): View
    {
        if (! empty($request)) {
            $all_payments = \App\Models\Payment::filtered($request)->orderBy('payment_date')->get();
            $payments = \App\Models\Payment::filtered($request)->orderBy('payment_date')->paginate(25, ['*'], 'payments');
            $payments->appends($request->except('page'));
        } else {
            $all_payments = \App\Models\Payment::orderBy('payment_date')->get();
            $payments = \App\Models\Payment::orderBy('payment_date')->paginate(25, ['*'], 'payments');
        }

        return view('payments.results', compact('payments', 'all_payments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-payment')]
    public function store(StorePaymentRequest $request): RedirectResponse
    {
        // dd($request);

        $donation = \App\Models\Donation::findOrFail($request->input('donation_id'));
        // create donation_payment
        $payment = new \App\Models\Payment;
        $payment->donation_id = $donation->donation_id;
        $payment->payment_amount = $request->input('payment_amount');
        $payment->note = $request->input('note');
        $payment->payment_date = $request->input('payment_date');
        $payment->payment_description = $request->input('payment_description');
        if ($request->input('payment_description') == 'Credit card') {
            $payment->ccnumber = substr($request->input('payment_idnumber'), -4);
        }
        if ($request->input('payment_description') == 'Check' || $request->input('payment_description') == 'Refund') {
            $payment->cknumber = $request->input('payment_idnumber');
        }
        $payment->save();

        flash('Payment ID#: <a href="'.url('/payment/'.$payment->payment_id).'">'.$payment->payment_id.'</a> added')->success();

        return Redirect::action([\App\Http\Controllers\DonationController::class, 'show'], $donation->donation_id);
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('show-payment')]
    public function show(int $id): View
    {
        $payment = \App\Models\Payment::with('donation.retreat', 'donation.contact', 'balance_transaction')->findOrFail($id);

        // dd($payment);
        return view('payments.show', compact('payment')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-payment')]
    public function edit(int $id): View
    {
        // get this retreat's information
        $payment = \App\Models\Payment::with('donation.contact', 'donation.retreat')->findOrFail($id);
        $payment_methods = config('polanco.payment_method');

        return view('payments.edit', compact('payment', 'payment_methods'));
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-payment')]
    public function update(UpdatePaymentRequest $request, int $id): RedirectResponse
    {
        $payment = \App\Models\Payment::findOrFail($id);
        $payment->payment_amount = $request->input('payment_amount');
        $payment->payment_date = $request->input('payment_date');
        $payment->payment_description = $request->input('payment_description');
        $payment->stripe_balance_transaction_id = $request->input('stripe_balance_transaction_id');
        if ($request->input('payment_description') == 'Credit card') {
            $payment->ccnumber = substr($request->input('payment_idnumber'), -4);
        }
        if ($request->input('payment_description') == 'Check' || $request->input('payment_description') == 'Refund') {
            $payment->cknumber = $request->input('payment_idnumber');
        }
        $payment->note = $request->input('note');
        // dd($payment);
        $payment->save();

        flash('Payment ID#: <a href="'.url('/payment/'.$payment->payment_id).'">'.$payment->payment_id.'</a> updated')->success();

        return Redirect::action([\App\Http\Controllers\DonationController::class, 'show'], $payment->donation_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete-payment')]
    public function destroy(int $id): RedirectResponse
    {
        $payment = \App\Models\Payment::findOrFail($id);

        \App\Models\Payment::destroy($id);
        // disassociate registration with a donation that is being deleted - there should only be one

        flash('Payment ID#: '.$payment->payment_id.' deleted')->warning()->important();

        return Redirect::action([\App\Http\Controllers\DonationController::class, 'show'], $payment->donation_id);
    }
}
