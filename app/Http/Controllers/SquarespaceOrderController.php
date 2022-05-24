<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \App\Traits\SquareSpaceTrait;

class SquarespaceOrderController extends Controller
{   use SquareSpaceTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-squarespace-order');
        $orders = \App\Models\SsOrder::whereIsProcessed(0)->paginate(25, ['*'], 'ss_orders');
        $processed_orders = \App\Models\SsOrder::whereIsProcessed(1)->paginate(25, ['*'], 'ss_unprocessed_orders');

        return view('squarespace.order.index', compact('orders','processed_orders'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-squarespace-order');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $this->authorize('show-squarespace-order');
        $order = \App\Models\SsOrder::findOrFail($id);
        $retreats = $this->upcoming_retreats();
        $list = $this->matched_contacts($order);
        // dd($order, $lastnames, $emails, $mobile_phones, $home_phones, $work_phones, $contacts, $list);
        return view('squarespace.order.edit', compact('order','list','retreats'));

    }

    /**
     * Show an order to confirm the retreatant for a SquareSpace order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {

        $this->authorize('show-squarespace-order');
        $order = \App\Models\SsOrder::findOrFail($id);
        $retreats = $this->upcoming_retreats();
        $matching_contacts = $this->matched_contacts($order);

        // dd($order, $lastnames, $emails, $mobile_phones, $home_phones, $work_phones, $contacts, $list);
        return view('squarespace.order.confirm', compact('order','matching_contacts','retreats'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
