<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
//use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
//use Input;
use Carbon\Carbon;

class RoomsController extends Controller
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
        //
        
        $rooms = \montserrat\Room::orderBy('building_id', 'asc','name','asc')->get();
         foreach ($rooms as $room) {
            $room->building = \montserrat\Location::find($room->building_id)->name;
           
         }
         $roomsort = $rooms->sortBy(function($building) {
         return sprintf('%-12s%s',$building->building,$building->name);});
          //dd($rooms);      
        return view('rooms.index',compact('roomsort'));   //
    
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $locations = \montserrat\Location::orderby('name')->lists('name','id');
        return view('rooms.create',compact('locations'));  
    
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
           $this->validate($request, [
            'name' => 'required',
            'building_id' => 'integer|min:0',
            'occupancy' => 'integer|min:0'
        ]);
        $room = new \montserrat\Room;
        $room->building_id = $request->input('building_id');
        $room->name = $request->input('name');
        $room->description = $request->input('description');
        $room->notes = $request->input('notes');
        $room->access = $request->input('access');
        $room->type = $request->input('type');
        $room->occupancy = $request->input('occupancy');
        $room->status= $request->input('status');
        $room->save();
return Redirect::action('RoomsController@index');
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
        
        $room = \montserrat\Room::find($id);
        $building =  \montserrat\Room::find($id)->location;
        $room->building = $building->name;
        
       return view('rooms.show',compact('room'));//
    
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
        $locations = \montserrat\Location::orderby('name')->lists('name','id');
        $room= \montserrat\Room::find($id);
      
       return view('rooms.edit',compact('room','locations'));
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
        $this->validate($request, [
            'name' => 'required',
            'building_id' => 'integer|min:0',
            'occupancy' => 'integer|min:0'
        ]);
           
        $room = \montserrat\Room::findOrFail($request->input('id'));
        $room->building_id = $request->input('building_id');
        $room->name = $request->input('name');
        $room->description = $request->input('description');
        $room->notes = $request->input('notes');
        $room->access = $request->input('access');
        $room->type = $request->input('type');
        $room->occupancy = $request->input('occupancy');
        $room->status = $request->input('status');
        $room->save();

        return Redirect::action('RoomsController@index');
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
        \montserrat\Room::destroy($id);
        return Redirect::action('RoomsController@index');
    }
    
    /**
     * Display the room schedules for a particular month/year - default this month.
     *
     * @param  int  $ym
     * @return \Illuminate\Http\Response
     */
    public function schedule($ym = null, $building = null)
    {   //dd($ym);
    
        //
        if ((!isset($ym)) or ($ym==0)) {
            $dt = Carbon::now();
            //dd($dt);
        } else{
            if (!$dt = Carbon::parse($ym)) {
                    return view('404');
            }
        }
        $upcoming = clone $dt;
        $dts[0] = $dt;
        //dd($dts);
        for ($i=1; $i<=31;$i++) {
            $dts[$i] = Carbon::parse($upcoming->addDays((1)));
        }
        $rooms = \montserrat\Room::with('location')->get();
        //dd($rooms);
        //foreach ($rooms as $room) {
        //    $room->building = \montserrat\Location::find($room->building_id)->name;
        //}
        $roomsort = $rooms->sortBy(function($room) {
            return sprintf('%-12s%s', $room->building_id, $room->name);
        });
        
        $registrations = \montserrat\Registration::where('start','>=',$dts[0])->where('start','<=',$dts[30])->with('room','room.location','retreatant','retreat')->where('room_id','>',0)->get();
        //dd($registrations);
        
        // create matrix of rooms and dates
        foreach ($rooms as $room) {
            foreach ($dts as $dt) {
                //dd($dt);
                $m[$room->id][$dt->toDateString()]['status'] = 'A';
                $m[$room->id][$dt->toDateString()]['registration_id'] = NULL;
                $m[$room->id][$dt->toDateString()]['retreatant_id'] = NULL;
                $m[$room->id][$dt->toDateString()]['retreatant_name'] = NULL;
                
                $m[$room->id]['room'] = $room->name;
                $m[$room->id]['building'] = $room->location->name;
                $m[$room->id]['occupancy'] = $room->occupancy;
                
            
            }
        }
        // dd($m[1]);
        /* 
         * for each registration, get the number of days 
         * for each day, check if the status is set (in other words it is in the room schedule matrix)
         * if it is in the matrix update the status to reserved
         */
        
        foreach ($registrations as $registration) {
            
            $numdays = ($registration->retreat->end->diffInDays($registration->retreat->start))-1;
            
            for ($i=0; $i<=$numdays;$i++) {
                $matrixdate = $registration->retreat->start->copy()->addDays($i);
                if (array_key_exists($matrixdate->toDateString(),$m[$registration->room_id])) {
                        $m[$registration->room_id][$matrixdate->toDateString()]['status']='R';
                        $m[$registration->room_id][$matrixdate->toDateString()]['registration_id']=$registration->id;
                        $m[$registration->room_id][$matrixdate->toDateString()]['retreatant_id']=$registration->retreatant_id;
                        $m[$registration->room_id][$matrixdate->toDateString()]['retreatant_name']= $registration->retreatant->lastname.', '.$registration->retreatant->firstname;
                        /* For now just handle marking the room as reserved with a URL to the registration and name in the title when hovering over it
                         * I am thinking about using diffInDays to see if the retreatant arrived on the day that we are looking at or sooner
                         * If they have not yet arrived then the first day should be reserved but not occupied. 
                         * Occupied will be the same link to the registration. 
                         */                  
                     }
        
            }
        }
        
        return view('rooms.sched2',compact('dts','roomsort','m'));
    }
}