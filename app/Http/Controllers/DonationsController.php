<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DonationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('confirmAttendance');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-donation');
        $donations = \App\Donation::orderBy('donation_date', 'desc')->with('contact')->paginate(100);
        //dd($donations);
        return view('donations.index', compact('donations'));
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $this->authorize('create-donation');

        $retreats = \App\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date", ">", \Carbon\Carbon::today()->subWeek())->where("is_active", "=", 1)->orderBy('start_date')->pluck('description', 'id');
        $retreats->prepend('Unassigned', 0);
        $donors = \App\Contact::whereContactType(config('polanco.contact_type.individual'))->orderBy('sort_name')->pluck('sort_name', 'id');
        
        $descriptions = \App\DonationType::orderby('name')->pluck('name', 'id');
        $descriptions->prepend('Unassigned', 0);
        
        $dt_today =  \Carbon\Carbon::today();
        $defaults['today'] = $dt_today->month.'/'.$dt_today->day.'/'.$dt_today->year;
        $defaults['retreat_id']=0;
        return view('donations.create', compact('retreats', 'donors', 'descriptions', 'defaults'));
    
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
         $this->authorize('show-donation');
        $donation= \App\Donation::with('payments', 'contact')->findOrFail($id);
        return view('donations.show', compact('donation'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-donation');
        //get this retreat's information
        $donation = \App\Donation::with('payments', 'contact')->findOrFail($id);
        $descriptions = \App\DonationType::orderby('name')->pluck('name', 'id');
        $descriptions->prepend('Unassigned', 0);

        return view('donations.edit', compact('donation','descriptions'));
   
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
        $this->authorize('delete-donation');
        $donation= \App\Donation::findOrFail($id);
        //deletion of payments implied on the model 
        \App\Donation::destroy($id);
        return Redirect::action('DonationsController@index');

    }
}
