<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class LocationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $this->authorize('show-location');

        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $locations = \App\Models\Location::orderBy('name')->get();

        return view('admin.locations.index', compact('locations', 'location_types'));
    }

    public function index_type($type = null): View
    {
        $this->authorize('show-location');

        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $locations = \App\Models\Location::whereType($type)->orderBy('name')->get();

        return view('admin.locations.index', compact('locations', 'location_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create-location');

        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $parents = \App\Models\Location::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        $rooms = \App\Models\Room::orderBy('name')->pluck('name', 'id');
        $rooms->prepend('N/A', 0);

        return view('admin.locations.create', compact('location_types', 'parents', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $this->authorize('create-location');

        $location = new \App\Models\Location;
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

        flash('Location: <a href="'.url('/admin/location/'.$location->id).'">'.$location->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->authorize('show-location');

        $location = \App\Models\Location::findOrFail($id);
        $children = \App\Models\Location::whereParentId($id)->orderBy('name')->get();

        return view('admin.locations.show', compact('location', 'children'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorize('update-location');

        $location = \App\Models\Location::findOrFail($id);

        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $parents = \App\Models\Location::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        $rooms = \App\Models\Room::orderBy('name')->pluck('name', 'id');
        $rooms->prepend('N/A', 0);

        return view('admin.locations.edit', compact('location', 'location_types', 'parents', 'rooms')); //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-location');

        $location = \App\Models\Location::findOrFail($id);

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

        flash('Location: <a href="'.url('/admin/location/'.$location->id).'">'.$location->name.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $location->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-location');

        $location = \App\Models\Location::findOrFail($id);
        \App\Models\Location::destroy($id);

        flash('Location: '.$location->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
