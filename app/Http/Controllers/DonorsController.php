<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;

use montserrat\Http\Requests;

class DonorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('show-donor');
        //only show donors that do not have a contact_id
        $donors = \montserrat\Donor::whereContactId(NULL)->orderBy('sort_name')->paginate(100);
        return view('donors.index',compact('donors'));   //
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // will not be creating any PPD donor records
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // will not be creating any PPD donor records
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $this->authorize('show-donor');
        $donor = \montserrat\Donor::whereDonorId($id)->first();
        //dd($donor);
        $sortnames = \montserrat\Contact::whereSortName($donor->sort_name)->get();
        $lastnames = \montserrat\Contact::whereLastName($donor->LName)->get();
                
        return view('donors.show',compact('donor','sortnames','lastnames'));//

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    
    public function assign($donor_id, $contact_id) {
        // dd($donor_id, $contact_id);
        $donor = \montserrat\Donor::whereDonorId($donor_id)->first();
        if (empty($donor->contact_id)) {
            $donor->contact_id = $contact_id;
            $donor->save();
        }
        return redirect()->action('DonorsController@index');
    }
}
