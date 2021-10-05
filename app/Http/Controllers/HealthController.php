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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-admin');
        $results = collect([]);
        $email_primary = DB::table('email')->whereIsPrimary(1)->groupBy('contact_id')->havingRaw('count(id) > 1')->get();
        $results->put('email_primary', $email_primary->count());

        dd($results, $email_primary);

        return view('health.index', compact('results'));   //
    }

}
