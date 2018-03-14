<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon;

class PagesController extends Controller
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
    
    public function about()
    {
        return view('pages.about');   //
    }
    
    public function retreat()
    {
        return view('pages.retreat');   //
    }
    
    public function reservation()
    {
        return view('pages.reservation');   //
    }
    public function room()
    {
        return view('pages.room');   //
    }
    public function housekeeping()
    {
        return view('pages.housekeeping');   //
    }
    public function maintenance()
    {
        return view('pages.maintenance');   //
    }
    
    public function grounds()
    {
        return view('pages.grounds');   //
    }
    public function kitchen()
    {
        return view('pages.kitchen');   //
    }
    public function donation()
    {
        return view('pages.donation');   //
    }
    public function bookstore()
    {
        return view('pages.bookstore');   //
    }
    public function user()
    {
        return view('pages.user');   //
    }
    public function restricted()
    {
        return view('pages.restricted');   //
    }
    public function support()
    {
        return view('pages.support');   //
    }
    public function welcome()
    {
        $next_week=(Carbon\Carbon::now()->addWeeks(1));
        /* $client = new \GuzzleHttp\Client();
        $result = $client->get('http://labs.bible.org/api/?passage=random')->getBody();
        $quote = strip_tags($result->getContents(),'<b>');
         * 
         */
        $quote = 'Jesus loves me this I know';
        // $retreats = \App\Retreat::where('start_date', '<=', $next_week)->where('end_date', '>=', date('Y-m-d'))->orderBy('start_date')->get();
        return view('welcome',compact('quote'));   //
    }
    public function retreatantinforeport($id)
    {
        $retreat = \App\Retreat::where('idnumber', '=', $id)->first();
        //unsorted registrations
        //$registrations = \App\Registration::where('event_id','=',$retreat->id)->with('retreat','retreatant.languages','retreatant.parish.contact_a.address_primary','retreatant.prefix','retreatant.suffix','retreatant.address_primary.state','retreatant.phones.location','retreatant.emails.location','retreatant.emergency_contact','retreatant.notes','retreatant.occupation')->get();
        //registrations sorted by contact's sort_name
        $registrations = \App\Registration::select(\DB::raw('participant.*', 'contact.*'))
                ->join('contact', 'participant.contact_id', '=', 'contact.id')
                ->where('participant.event_id', '=', $retreat->id)
                ->whereCanceledAt(null)
                ->with('retreat', 'retreatant.languages', 'retreatant.parish.contact_a.address_primary', 'retreatant.prefix', 'retreatant.suffix', 'retreatant.address_primary.state', 'retreatant.phones.location', 'retreatant.emails.location', 'retreatant.emergency_contact', 'retreatant.notes', 'retreatant.occupation')
                ->orderBy('contact.sort_name', 'asc')
                ->orderBy('participant.notes', 'asc')
                ->get();
        
        return view('reports.retreatantinfo2', compact('registrations'));   //
    }
    
    public function contact_info_report($id)
    {
        $person = \App\Contact::findOrFail($id);
        return view('reports.contact_info', compact('person'));   //
    }
    
    public function retreatlistingreport($id)
    {
        $retreat = \App\Retreat::where('idnumber', '=', $id)->first();
        //$registrations = \App\Registration::where('event_id','=',$retreat->id)->with('retreat','retreatant')->get();
        $registrations = \App\Registration::select(\DB::raw('participant.*', 'contact.*'))
                ->join('contact', 'participant.contact_id', '=', 'contact.id')
                ->where('participant.event_id', '=', $retreat->id)
                ->whereCanceledAt(null)
                ->with('retreat', 'retreatant.languages', 'retreatant.parish.contact_a.address_primary', 'retreatant.prefix', 'retreatant.suffix', 'retreatant.address_primary.state', 'retreatant.phones.location', 'retreatant.emails.location', 'retreatant.emergency_contact', 'retreatant.notes', 'retreatant.occupation')
                ->orderBy('contact.sort_name', 'asc')
                ->orderBy('participant.notes', 'asc')
                ->get();
        
        return view('reports.retreatlisting', compact('registrations'));   //
    }
    public function retreatrosterreport($id)
    {
        $retreat = \App\Retreat::where('idnumber', '=', $id)->first();
  //        $registrations = \App\Registration::where('event_id','=',$retreat->id)->with('retreat','retreatant.suffix','retreatant.address_primary','retreatant.prefix')->get();
        //dd($registrations);
        $registrations = \App\Registration::select(\DB::raw('participant.*', 'contact.*'))
                ->join('contact', 'participant.contact_id', '=', 'contact.id')
                ->where('participant.event_id', '=', $retreat->id)
                ->whereCanceledAt(null)
                ->with('retreat', 'retreatant.languages', 'retreatant.parish.contact_a.address_primary', 'retreatant.prefix', 'retreatant.suffix', 'retreatant.address_primary.state', 'retreatant.phones.location', 'retreatant.emails.location', 'retreatant.emergency_contact', 'retreatant.notes', 'retreatant.occupation')
                ->orderBy('contact.sort_name', 'asc')
                ->orderBy('participant.notes', 'asc')
                ->get();
        
        return view('reports.retreatroster', compact('registrations'));   //
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
}
