<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;

class LocationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-location');

        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $locations = \App\Location::orderBy('name')->get();

        return view('admin.locations.index', compact('locations', 'location_types'));
    }

    public function index_type($type = null)
    {
        $this->authorize('show-location');

        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $locations = \App\Location::whereType($type)->orderBy('name')->get();

        return view('admin.locations.index', compact('locations', 'location_types'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-location');

        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $parents = \App\Location::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        $rooms = \App\Room::orderBy('name')->pluck('name', 'id');
        $rooms->prepend('N/A', 0);

        return view('admin.locations.create', compact('location_types', 'parents', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRequest $request)
    {
        $this->authorize('create-location');

        $location = new \App\Location;
        $location->name = $request->input('name');
        $location->description = $request->input('description');
        $location->occupancy = $request->input('occupancy');
        $location->notes = $request->input('notes');
        $location->label = $request->input('label');
        $location->latitude = $request->input('latitude');
        $location->longitude = $request->input('longitude');
        $location->type = $request->input('type');
        $location->room_id = $request->input('room_id');
        $location->parent_id = $request->input('parent_id');

        $location->save();

        return Redirect::action('LocationController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-location');

        $location = \App\Location::findOrFail($id);
        $children = \App\Location::whereParentId($id)->orderBy('name')->get();

        return view('admin.locations.show', compact('location', 'children'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-location');

        $location = \App\Location::findOrFail($id);

        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $parents = \App\Location::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        $rooms = \App\Room::orderBy('name')->pluck('name', 'id');
        $rooms->prepend('N/A', 0);

        return view('admin.locations.edit', compact('location', 'location_types','parents','rooms')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationRequest $request, $id)
    {
        $this->authorize('update-location');

        $location = \App\Location::findOrFail($id);

        $location->name = $request->input('name');
        $location->description = $request->input('description');
        $location->occupancy = $request->input('occupancy');
        $location->notes = $request->input('notes');
        $location->label = $request->input('label');
        $location->latitude = $request->input('latitude');
        $location->longitude = $request->input('longitude');
        $location->type = $request->input('type');
        $location->room_id = $request->input('room_id');
        $location->parent_id = $request->input('parent_id');

        $location->save();

        return Redirect::action('LocationController@show', $location->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-location');

        \App\Location::destroy($id);

        return Redirect::action('LocationController@index');
    }
}
