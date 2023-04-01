<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreDonationTypeRequest;
use App\Http\Requests\UpdateDonationTypeRequest;
use Illuminate\Support\Facades\Redirect;

class DonationTypeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $this->authorize('show-donation-type');
        $donation_types = \App\Models\DonationType::orderBy('label')->get();

        return view('admin.donation_types.index', compact('donation_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
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
    public function store(StoreDonationTypeRequest $request): RedirectResponse
    {
        $this->authorize('create-donation-type');

        $donation_type = new \App\Models\DonationType;
        $donation_type->label = $request->input('label');
        $donation_type->name = $request->input('name');
        $donation_type->value = strval($request->input('value'));
        $donation_type->description = $request->input('description');
        $donation_type->is_active = $request->input('is_active');

        $donation_type->save();

        flash('Donation type: <a href="'.url('/admin/donation_type/'.$donation_type->id).'">'.$donation_type->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): View
    {
        $this->authorize('show-donation-type');

        $donation_type = \App\Models\DonationType::findOrFail($id);

        return view('admin.donation_types.show', compact('donation_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id): View
    {
        $this->authorize('update-donation-type');

        $donation_type = \App\Models\DonationType::findOrFail($id);

        return view('admin.donation_types.edit', compact('donation_type')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDonationTypeRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-donation-type');

        $donation_type = \App\Models\DonationType::findOrFail($request->input('id'));
        $donation_type->name = $request->input('name');
        $donation_type->label = $request->input('label');
        $donation_type->is_active = $request->input('is_active');
        $donation_type->value = strval($request->input('value'));
        $donation_type->description = $request->input('description');
        $donation_type->save();

        flash('Donation type: <a href="'.url('/admin/donation_type/'.$donation_type->id).'">'.$donation_type->name.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-donation-type');

        $donation_type = \App\Models\DonationType::findOrFail($id);

        \App\Models\DonationType::destroy($id);

        flash('Donation type: '.$donation_type->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
