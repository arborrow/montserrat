<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;
use Auth;
class RetreatsController extends Controller
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
        //dd(Auth::User());
        $retreats = \montserrat\Retreat::whereDate('end', '>=', date('Y-m-d'))->orderBy('start','asc')->with('retreatmasters','innkeeper','assistant')->get();
        $oldretreats = \montserrat\Retreat::whereDate('end', '<', date('Y-m-d'))->orderBy('start','desc')->with('retreatmasters','innkeeper','assistant')->get();
        
        //dd($oldretreats);    
        return view('retreats.index',compact('retreats','oldretreats'));   //
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $d=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_director','1')->orderBy('fullname')->lists('fullname','id');
        $i=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_innkeeper','1')->orderBy('fullname')->lists('fullname','id');
        $a=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_assistant','1')->orderBy('fullname')->lists('fullname','id');
        $d->prepend('N/A',0);
        $i->prepend('N/A',0);
        $a->prepend('N/A',0);
        
        return view('retreats.create',compact('d','i','a'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { // dd($request);
        $this->validate($request, [
            'idnumber' => 'required|unique:retreats',
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start',
            'title' => 'required',
            'innkeeperid' => 'integer|min:0',
            'assistantid' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean'
        ]);
        $retreat = new \montserrat\Retreat;
        $retreat->idnumber = $request->input('idnumber');
        $retreat->start = $request->input('start');
        $retreat->end = $request->input('end');
        $retreat->title = $request->input('title');
        $retreat->description = $request->input('description');
        $retreat->type = $request->input('type');
        $retreat->silent = $request->input('silent');
        $retreat->amount = $request->input('amount');
        $retreat->attending = $request->input('attending');
        $retreat->year = $request->input('year');
        $retreat->innkeeperid = $request->input('innkeeperid');
        $retreat->assistantid = $request->input('assistantid');
        $retreat->save();
        //dd($request->get('directors'));
        //dd($request->input('directors'));
        if (empty($request->input('directors')) or in_array(0,$request->input('directors'))) {
            $retreat->retreatmasters()->detach();
        } else {
            $retreat->retreatmasters()->sync($request->input('directors'));
        }
        
        return Redirect::action('RetreatsController@index');//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $retreat = \montserrat\Retreat::with('retreatmasters')->find($id);
        $director = \montserrat\Retreat::find($id)->director;
        $innkeeper = \montserrat\Retreat::find($id)->innkeeper;
        $assistant = \montserrat\Retreat::find($id)->assistant;
        $registrations = \montserrat\Registration::where('retreat_id','=',$id)->with('retreatant','retreatant.parish')->get();
        //dd($retreat);
        if (empty($director)) {
                $retreat->directorname = 'Not assigned';
            } else {
                $retreat->directorname = $director->firstname.' '.$director->lastname;
            }
            if (empty($innkeeper)) {
                $retreat->innkeepername = 'Not assigned';
            } else {
            $retreat->innkeepername = $innkeeper->firstname.' '.$innkeeper->lastname;
            }
            if (empty($assistant)) {
                $retreat->assistantname = 'Not assigned';
            } else {
                $retreat->assistantname = $assistant->firstname.' '.$assistant->lastname;
            }
        
       return view('retreats.show',compact('retreat','director','registrations'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function edit($id)
    //{
    //   $retreats = \montserrat\Retreat::();
    //   return view('retreats.edit',compact('retreats'));
    //  }
public function edit($id)
    {
        //get this retreat's information
        $retreat = \montserrat\Retreat::with('retreatmasters','assistant','innkeeper')->find($id);

        //create lists of retreat directors, innkeepers, and assistants from relationship to retreat house 
        $retreat_house = \montserrat\Contact::with('retreat_directors.contact_b','retreat_innkeepers.contact_b','retreat_assistants.contact_b')->find(CONTACT_MONTSERRAT);
        
        foreach ($retreat_house->retreat_innkeepers as $innkeeper) {
            $i[$innkeeper->contact_id_b]=$innkeeper->contact_b->sort_name;
        }
        asort($i);
        $i=array(0=>'N/A')+$i;
        
        foreach ($retreat_house->retreat_directors as $director) {
            $d[$director->contact_id_b]=$director->contact_b->sort_name;
        }
        asort($d);
        $d=array(0=>'N/A')+$d;
        
        foreach ($retreat_house->retreat_assistants as $assistant) {
            $a[$assistant->contact_id_b]=$assistant->contact_b->sort_name;
        }
        asort($a);
        $a=array(0=>'N/A')+$a;
        
       //dd($a);
       return view('retreats.edit',compact('retreat','d','i','a'));
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
      // dd($request);
        $this->validate($request, [
            'idnumber' => 'required|unique:retreats,idnumber,'.$id,
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start',
            'title' => 'required',
            'innkeeperid' => 'integer|min:0',
            'assistantid' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean'
        ]);
        $retreat = \montserrat\Retreat::findOrFail($request->input('id'));
        $retreat->idnumber = $request->input('idnumber');
        $retreat->start = $request->input('start');
        $retreat->end = $request->input('end');
        $retreat->title = $request->input('title');
        $retreat->description = $request->input('description');
        $retreat->type = $request->input('type');
        $retreat->silent = $request->input('silent');
        $retreat->amount = $request->input('amount');
        $retreat->attending = $request->input('attending');
        $retreat->year = $request->input('year');
        $retreat->innkeeperid = $request->input('innkeeperid');
        $retreat->assistantid = $request->input('assistantid');
        $retreat->save();
        
        if (empty($request->input('directors')) or in_array(0,$request->input('directors'))) {
            $retreat->retreatmasters()->detach();
        } else {
            $retreat->retreatmasters()->sync($request->input('directors'));
        }
       
        return Redirect::action('RetreatsController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       \montserrat\Retreat::destroy($id);
       return Redirect::action('RetreatsController@index');
       //
    }
    
}
