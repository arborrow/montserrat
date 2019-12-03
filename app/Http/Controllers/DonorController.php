<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonorController extends Controller
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
        $this->authorize('show-donor');
        //only show donors that do not have a contact_id
        $donors = \App\Donor::whereContactId(null)->orderBy('sort_name')->paginate(100);

        return view('donors.index', compact('donors'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // will not be creating any PPD donor records
        $this->authorize('create-donor');

        return $this->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // will not be creating any PPD donor records
        $this->authorize('create-donor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-donor');
        $donor = \App\Donor::whereDonorId($id)->first();
        //dd($donor);
        $sortnames = \App\Contact::whereSortName($donor->sort_name)->get();
        $lastnames = \App\Contact::whereLastName($donor->LName)->get();

        return view('donors.show', compact('donor', 'sortnames', 'lastnames')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-donor');

        return $this->index();
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
        $this->authorize('update-donor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-donor');
    }

    public function assign($donor_id, $contact_id)
    {
        // dd($donor_id, $contact_id);
        $this->authorize('update-donor');
        $donor = \App\Donor::whereDonorId($donor_id)->first();
        if (empty($donor->contact_id)) {
            $donor->contact_id = $contact_id;
            $donor->save();
        }

        return redirect()->action('DonorController@index');
    }

    public function add($donor_id)
    {
        $this->authorize('create-contact');
        $person = new \App\Contact;
        $donor = \App\Donor::findOrFail($donor_id);
        //dd($donor);

        if (isset($donor->FName)) {
            $person->first_name = $donor->FName;
        }
        if (isset($donor->MInitial)) {
            $person->middle_name = $donor->MInitial;
        }
        if (isset($donor->LName)) {
            $person->last_name = $donor->LName;
        }
        if (isset($donor->sort_name)) {
            $person->sort_name = $donor->sort_name;
        } else {
            $person->sort_name = $person->last_name.', '.$person->firstname;
        }
        $person->display_name = $person->first_name.' '.$person->last_name;
        $person->contact_type = 1;
        $person->subcontact_type = 0;
        $person->save();

        if (isset($donor->Address)) {
            $home_address = new \App\Address;
            $state = \App\StateProvince::whereAbbreviation($donor->State)->whereCountryId(config('polanco.country_id_usa'))->first();

            $home_address->contact_id = $person->id;
            $home_address->location_type_id = config('polanco.location_type.home');
            $home_address->is_primary = 1;
            $home_address->street_address = $donor->Address;
            $home_address->supplemental_address_1 = $donor->Address2;
            $home_address->city = $donor->City;
            $home_address->state_province_id = $state->id;
            $home_address->postal_code = $donor->Zip;
            $home_address->country_id = config('polanco.country_id_usa');
            $home_address->save();
        }

        if (isset($donor->HomePhone)) {
            $phone_home_phone = new \App\Phone;
            $phone_home_phone->contact_id = $person->id;
            $phone_home_phone->location_type_id = config('polanco.location_type.home');
            $phone_home_phone->phone = $donor->HomePhone;
            $phone_home_phone->phone_type = 'Phone';
            $phone_home_phone->save();
        }
        if (isset($donor->cell_phone)) {
            $phone_home_mobile = new \App\Phone;
            $phone_home_mobile->contact_id = $person->id;
            $phone_home_mobile->location_type_id = config('polanco.location_type.home');
            $phone_home_mobile->phone = $donor->cell_phone;
            $phone_home_mobile->phone_type = 'Mobile';
            $phone_home_mobile->save();
        }

        if (isset($donor->WorkPhone)) {
            $phone_work_phone = new \App\Phone;
            $phone_work_phone->contact_id = $person->id;
            $phone_work_phone->location_type_id = config('polanco.location_type.work');
            $phone_work_phone->phone = $donor->WorkPhone;
            $phone_work_phone->phone_type = 'Phone';
            $phone_work_phone->save();
        }
        if (isset($donor->EMailAddress)) {
            $email_home = new \App\Email;
            $email_home->contact_id = $person->id;
            $email_home->location_type_id = config('polanco.location_type.home');
            $email_home->email = $donor->EMailAddress;
            $email_home->is_primary = 1;
            $email_home->save();
        }

        if (empty($donor->contact_id)) {
            $donor->contact_id = $person->id;
            $donor->save();
        }

        return redirect()->action('DonorController@index');
    }
}
