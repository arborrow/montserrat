<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Address;

/**
 * In production, addresses are primarily managed by the person or contact controller.
 * In testing, the address controller uses CRUD-style permissions which are theoretical rather than the contact CRUD permissions used in production
 * In other words, in production, the create-contact permission is used rather than create-address
 */


class AddressController extends Controller
{
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
        $this->authorize('show-address');
        $addresses = \App\Address::orderBy('postal_code','asc')->with('addressee')->paginate(100);
        return view('addresses.index',compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-address');
        $countries = \App\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);
        $states = \App\StateProvince::orderBy('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $contacts = \App\Contact::orderBy('sort_name')->pluck('sort_name', 'id');
        $location_types = \App\LocationType::whereIsActive(1)->orderBy('name')->pluck('name', 'id');

        return view('addresses.create',compact('countries','states','contacts','location_types'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-address');
        $address = new \App\Address;
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

        return Redirect::action('AddressController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-address');
        $address = \App\Address::with('addressee')->findOrFail($id);

        return view('addresses.show', compact('address'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-address');

        $countries = \App\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);
        $states = \App\StateProvince::orderBy('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $contacts = \App\Contact::orderBy('sort_name')->pluck('sort_name', 'id');
        $location_types = \App\LocationType::whereIsActive(1)->orderBy('name')->pluck('name', 'id');
        $address = \App\Address::findOrFail($id);

        return view('addresses.edit',compact('address','countries','states','contacts','location_types'));
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
        $this->authorize('update-address');
        $address = \App\Address::findOrFail($id);
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

        return Redirect::action('AddressController@show', $address->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-address');
        $address = \App\Address::findOrFail($id);
        $contact_id = $address->contact_id;
        \App\Address::destroy($id);

        return Redirect::action('PersonController@show', $contact_id);
    }
}
