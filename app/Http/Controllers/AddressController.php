<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Redirect;

/**
 * In production, addresses are primarily managed by the person or contact controller.
 * In testing, the address controller uses CRUD-style permissions which are theoretical rather than the contact CRUD permissions used in production
 * In other words, in production, the create-contact permission is used rather than create-address.
 */
class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('show-address');
        $addresses = \App\Models\Address::orderBy('postal_code', 'asc')->with('addressee')->paginate(25, ['*'], 'addresses');

        return view('addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create-address');
        $countries = \App\Models\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', '');
        $states = \App\Models\StateProvince::orderBy('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', '');
        $contacts = \App\Models\Contact::orderBy('sort_name')->pluck('sort_name', 'id');
        $location_types = \App\Models\LocationType::whereIsActive(1)->orderBy('name')->pluck('name', 'id');

        return view('addresses.create', compact('countries', 'states', 'contacts', 'location_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request): RedirectResponse
    {
        $this->authorize('create-address');
        $address = new \App\Models\Address;
        $address->contact_id = $request->input('contact_id');
        $address->location_type_id = $request->input('location_type_id');
        $address->is_primary = $request->input('is_primary');
        $address->street_address = $request->input('street_address');
        $address->supplemental_address_1 = $request->input('supplemental_address_1');
        $address->city = $request->input('city');
        $address->state_province_id = $request->input('state_province_id');
        $address->postal_code = $request->input('postal_code');
        $address->country_id = $request->input('country_id');
        $address->save();

        flash('Address ID#: <a href="'.url('/address/'.$address->id).'">'.$address->id.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->authorize('show-address');
        $address = \App\Models\Address::with('addressee')->findOrFail($id);

        return view('addresses.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorize('update-address');

        $countries = \App\Models\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', '');
        $states = \App\Models\StateProvince::orderBy('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', '');
        $contacts = \App\Models\Contact::orderBy('sort_name')->pluck('sort_name', 'id');
        $location_types = \App\Models\LocationType::whereIsActive(1)->orderBy('name')->pluck('name', 'id');
        $address = \App\Models\Address::findOrFail($id);

        return view('addresses.edit', compact('address', 'countries', 'states', 'contacts', 'location_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-address');
        $address = \App\Models\Address::findOrFail($id);
        $address->contact_id = $request->input('contact_id');
        $address->location_type_id = $request->input('location_type_id');
        $address->is_primary = $request->input('is_primary');
        $address->street_address = $request->input('street_address');
        $address->supplemental_address_1 = $request->input('supplemental_address_1');
        $address->city = $request->input('city');
        $address->state_province_id = $request->input('state_province_id');
        $address->postal_code = $request->input('postal_code');
        $address->country_id = $request->input('country_id');
        $address->save();

        flash('Address ID#: <a href="'.url('/address/'.$address->id).'">'.$address->id.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $address->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-address');
        $address = \App\Models\Address::findOrFail($id);
        $contact_id = $address->contact_id;
        \App\Models\Address::destroy($id);

        flash('Address ID#: '.$address->id.' deleted')->warning()->important();

        return Redirect::action([\App\Http\Controllers\PersonController::class, 'show'], $contact_id);
    }
}
