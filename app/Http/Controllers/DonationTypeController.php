<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreDonationTypeRequest;
use App\Http\Requests\UpdateDonationTypeRequest;

class DonationTypeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-donation-type');
        $donation_types = \App\DonationType::orderBy('label')->get();

        return view('admin.donation_types.index', compact('donation_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-donation-type');

        return view('admin.donation_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDonationTypeRequest $request)
    {
        $this->authorize('create-donation-type');

        $donation_type = new \App\DonationType;
        $donation_type->label = $request->input('label');
        $donation_type->name = $request->input('name');
        $donation_type->value = strval($request->input('value'));
        $donation_type->description = $request->input('description');
        $donation_type->is_active = $request->input('is_active');

        $donation_type->save();

        flash('Donation type: <a href="'. url('/admin/donation_type/'.$donation_type->id) . '">'.$donation_type->name.'</a> added')->success();
        return Redirect::action('DonationTypeController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-donation-type');

        $donation_type = \App\DonationType::findOrFail($id);

        return view('admin.donation_types.show', compact('donation_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-donation-type');

        $donation_type = \App\DonationType::findOrFail($id);

        return view('admin.donation_types.edit', compact('donation_type')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDonationTypeRequest $request, $id)
    {
        $this->authorize('update-donation-type');

        $donation_type = \App\DonationType::findOrFail($request->input('id'));
        $donation_type->name = $request->input('name');
        $donation_type->label = $request->input('label');
        $donation_type->is_active = $request->input('is_active');
        $donation_type->value = strval($request->input('value'));
        $donation_type->description = $request->input('description');
        $donation_type->save();

        flash('Donation type: <a href="'. url('/admin/donation_type/'.$donation_type->id) . '">'.$donation_type->name.'</a> updated')->success();
        return Redirect::action('DonationTypeController@show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-donation-type');

        $donation_type = \App\DonationType::findOrFail($id);

        \App\DonationType::destroy($id);

        flash('Donation type: '.$donation_type->name . ' deleted')->warning()->important();
        return Redirect::action('DonationTypeController@index');
    }

}
