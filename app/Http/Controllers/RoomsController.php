<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;


class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $rooms = \App\Room::orderBy('building_id','name')->get();
          //dd($rooms);      
        return view('rooms.index',compact('rooms'));   //
    
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('rooms.create');  
    
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
        $room = new \App\Room;
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
        
        $room = \App\Room::find($id);
        
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
        $room= \App\Room::find($id);
      
       return view('rooms.edit',compact('room'));
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
           
        $room = \App\Room::findOrFail($request->input('id'));
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
        \App\Room::destroy($id);
        return Redirect::action('RoomsController@index');
    }
}