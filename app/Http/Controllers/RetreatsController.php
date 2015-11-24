<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

class RetreatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $retreats = \App\Retreat::whereDate('end', '>=', date('Y-m-d'))->orderBy('start','asc')->get();
        $oldretreats = \App\Retreat::whereDate('end', '<', date('Y-m-d'))->orderBy('start','desc')->get();
        
        foreach ($retreats as $retreat) {
            $director = \App\Retreat::find($retreat->id)->director;
            $innkeeper = \App\Retreat::find($retreat->id)->innkeeper;
            $assistant = \App\Retreat::find($retreat->id)->assistant;
            //dd($director);
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
            
        }
        foreach ($oldretreats as $oldretreat) {
            $director = \App\Retreat::find($oldretreat->id)->director;
            $innkeeper = \App\Retreat::find($oldretreat->id)->innkeeper;
            $assistant = \App\Retreat::find($oldretreat->id)->assistant;
            //dd($director);
            if (empty($director)) {
                $oldretreat->directorname = 'Not assigned';
            } else {
                $oldretreat->directorname = $director->firstname.' '.$director->lastname;
            }
            if (empty($innkeeper)) {
                $oldretreat->innkeepername = 'Not assigned';
            } else {
                $oldretreat->innkeepername = $innkeeper->firstname.' '.$innkeeper->lastname;
            }
            if (empty($assistant)) {
                $oldretreat->assistantname = 'Not assigned';
            } else {
                $oldretreat->assistantname = $assistant->firstname.' '.$assistant->lastname;
            }
            
        }
        
        return view('retreats.index',compact('retreats','oldretreats'));   //
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $directors = \App\Director::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        $innkeepers = \App\Innkeeper::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        $assistants = \App\Assistant::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
            
        // dd($directors);
        $d=array();
        foreach ($directors as $director) {
            $d[$director->id] = $director->lastname.', '.$director->firstname;
        }
        $i=array();
        foreach ($innkeepers as $innkeeper) {
            $i[$innkeeper->id] = $innkeeper->lastname.', '.$innkeeper->firstname;
        }
        $a=array();
        foreach ($assistants as $assistant) {
            $a[$assistant->id] = $assistant->lastname.', '.$assistant->firstname;
        }
        // dd($d);
        
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
            'directorid' => 'integer|min:0',
            'innkeeperid' => 'integer|min:0',
            'assistantid' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean'
        ]);
        $retreat = new \App\Retreat;
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
        $retreat->directorid = $request->input('directorid');
        $retreat->innkeeperid = $request->input('innkeeperid');
        $retreat->assistantid = $request->input('assistantid');
        $retreat->save();
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
        $retreat = \App\Retreat::find($id);
        $director = \App\Retreat::find($id)->director;
        $innkeeper = \App\Retreat::find($id)->innkeeper;
        $assistant = \App\Retreat::find($id)->assistant;
        $registrations = \App\Retreat::find($id)->registrations;
        foreach ($registrations as $registration) {
            $retreatant = \App\Registration::find($registration->id)->retreatant;
            //dd($director);
            if (empty($retreatant)) {
                $registration->retreatantname = 'Unknown retreatant';
                $registration->retreatantphone = 'Not available';
                $registration->retreatantparish = 'Unknown';
            } else {
                $registration->retreatantname = $retreatant->firstname.' '.$retreatant->lastname;
                $registration->retreatantmobilephone = $retreatant->mobilephone;
                $registration->retreatantparish = $retreatant->parish;
            }
            
        }
        // dd($registrations);
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
    //   $retreats = \App\Retreat::();
    //   return view('retreats.edit',compact('retreats'));
    //  }
public function edit($id)
    { $retreat = \App\Retreat::find($id);
      
        $directors = \App\Director::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        $innkeepers = \App\Innkeeper::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        $assistants = \App\Assistant::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
            
        // dd($directors);
        $d=array();
        foreach ($directors as $director) {
            $d[$director->id] = $director->lastname.', '.$director->firstname;
        }
        $i=array();
        foreach ($innkeepers as $innkeeper) {
            $i[$innkeeper->id] = $innkeeper->lastname.', '.$innkeeper->firstname;
        }
        $a=array();
        foreach ($assistants as $assistant) {
            $a[$assistant->id] = $assistant->lastname.', '.$assistant->firstname;
        }
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
            'directorid' => 'integer|min:0',
            'innkeeperid' => 'integer|min:0',
            'assistantid' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean'
        ]);
        $retreat = \App\Retreat::findOrFail($request->input('id'));
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
        $retreat->directorid = $request->input('directorid');
        $retreat->innkeeperid = $request->input('innkeeperid');
        $retreat->assistantid = $request->input('assistantid');
        $retreat->save();

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
       \App\Retreat::destroy($id);
       return Redirect::action('RetreatsController@index');
       //
    }
    
}
