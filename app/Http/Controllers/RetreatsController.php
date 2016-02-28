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
        $retreats = \montserrat\Retreat::whereDate('end', '>=', date('Y-m-d'))->orderBy('start','asc')->with('retreatmasters.retreatmaster')->get();
        $oldretreats = \montserrat\Retreat::whereDate('end', '<', date('Y-m-d'))->orderBy('start','desc')->with('retreatmasters.retreatmaster')->get();
        
        foreach ($retreats as $retreat) {
            $director = \montserrat\Retreat::find($retreat->id)->director;
            $innkeeper = \montserrat\Retreat::find($retreat->id)->innkeeper;
            $assistant = \montserrat\Retreat::find($retreat->id)->assistant;
            //dd($retreat->retreatmasters);
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
            $director = \montserrat\Retreat::find($oldretreat->id)->director;
            $innkeeper = \montserrat\Retreat::find($oldretreat->id)->innkeeper;
            $assistant = \montserrat\Retreat::find($oldretreat->id)->assistant;
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
        // $directors = \montserrat\Director::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        // $innkeepers = \montserrat\Innkeeper::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        // $assistants = \montserrat\Assistant::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        $d=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_director','1')->orderBy('fullname')->lists('fullname','id');
        $i=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_innkeeper','1')->orderBy('fullname')->lists('fullname','id');
        $a=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_assistant','1')->orderBy('fullname')->lists('fullname','id');
        $d->prepend('N/A',0);
        $i->prepend('N/A',0);
        $a->prepend('N/A',0);
        
        /*$d=array();
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
        }*/
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
        $retreat->directorid = $request->input('directorid');
        $retreat->innkeeperid = $request->input('innkeeperid');
        $retreat->assistantid = $request->input('assistantid');
        $retreat->save();
        //dd($request->get('directors'));
        
        foreach($request->get('directors') as $director_id) {
            //dd($retreat);
            
            $new_director = array(
                'retreat_id' => $retreat->id,
                'retreatmaster_id' => $director_id
            );
            $retreatmaster = new \montserrat\Retreatmaster($new_director);
            $retreatmaster->save();
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
        $retreat = \montserrat\Retreat::find($id);
        $director = \montserrat\Retreat::find($id)->director;
        $innkeeper = \montserrat\Retreat::find($id)->innkeeper;
        $assistant = \montserrat\Retreat::find($id)->assistant;
        $registrations = \montserrat\Registration::where('retreat_id','=',$id)->with('retreatant','retreatant.parish')->get();
        
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
    { $retreat = \montserrat\Retreat::find($id);
      /*
        $directors = \montserrat\Director::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        $innkeepers = \montserrat\Innkeeper::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
        $assistants = \montserrat\Assistant::where('active','1')->select('id','title','firstname','lastname','suffix')->orderBy('lastname')->get();
            
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
        } */
        $d=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_director','1')->orderBy('fullname')->lists('fullname','id');
        $i=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_innkeeper','1')->orderBy('fullname')->lists('fullname','id');
        $a=  \montserrat\Person::select(\DB::raw('CONCAT(lastname,", ",firstname) as fullname'), 'id')->where('is_assistant','1')->orderBy('fullname')->lists('fullname','id');
        $d[0] = 'Unspecified';
        $i[0] = 'Unspecified';
        $a[0] = 'Unspecified';
        
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
       \montserrat\Retreat::destroy($id);
       return Redirect::action('RetreatsController@index');
       //
    }
    
}
