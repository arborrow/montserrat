<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationTypeRequest;
use App\Http\Requests\UpdateDonationTypeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class DonationTypeController extends Controller
{
    #[Authorize('show-donation-type')]
    public function index(): View
    {
        $donation_types = \App\Models\DonationType::orderBy('label')->get();

        return view('admin.donation_types.index', compact('donation_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-donation-type')]
    public function create(): View
    {
        return view('admin.donation_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-donation-type')]
    public function store(StoreDonationTypeRequest $request): RedirectResponse
    {
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
     */
    #[Authorize('show-donation-type')]
    public function show(int $id): View
    {
        $donation_type = \App\Models\DonationType::findOrFail($id);

        return view('admin.donation_types.show', compact('donation_type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-donation-type')]
    public function edit(int $id): View
    {
        $donation_type = \App\Models\DonationType::findOrFail($id);

        return view('admin.donation_types.edit', compact('donation_type')); //
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-donation-type')]
    public function update(UpdateDonationTypeRequest $request, int $id): RedirectResponse
    {
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
     */
    #[Authorize('delete-donation-type')]
    public function destroy(int $id): RedirectResponse
    {
        $donation_type = \App\Models\DonationType::findOrFail($id);

        \App\Models\DonationType::destroy($id);

        flash('Donation type: '.$donation_type->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
