<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HealthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Run all database health checks and display list of results
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-admin');
        $results = collect([]);
        $results->put('primary_address',$this->check_primary_address());
        $results->put('primary_email',$this->check_primary_email());
        $results->put('primary_phone',$this->check_primary_phone());
        //dd($results['primary_email']);
        return view('health.index', compact('results'));   //
    }

    /**
     * Run the primary address check to ensure there is one and only one primary email address for each contact_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_primary_address()
    {
        $this->authorize('show-admin');
        $results = collect([]);
        $address_primary = DB::table('address')->whereIsPrimary(1)->groupBy('contact_id')->havingRaw('count(id) > 1')->select('contact_id','street_address')->get();

        return $address_primary;   //
    }

    /**
     * Run the primary email check to ensure there is one and only one primary email address for each contact_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_primary_email()
    {
        $this->authorize('show-admin');
        $results = collect([]);
        $email_primary = DB::table('email')->whereIsPrimary(1)->groupBy('contact_id')->havingRaw('count(id) > 1')->select('contact_id','email')->get();

        return $email_primary;   //
    }

    /**
     * Run the primary address check to ensure there is one and only one primary email address for each contact_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_primary_phone()
    {
        $this->authorize('show-admin');
        $results = collect([]);
        $phone_primary = DB::table('phone')->whereIsPrimary(1)->groupBy('contact_id')->havingRaw('count(id) > 1')->select('contact_id','phone')->get();

        return $phone_primary;   //
    }


}
