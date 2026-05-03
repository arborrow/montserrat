<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class LocationController extends Controller
{
    #[Authorize('show-location')]
    public function index(): View
    {
        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $locations = \App\Models\Location::orderBy('name')->get();

        return view('admin.locations.index', compact('locations', 'location_types'));
    }

    #[Authorize('show-location')]
    public function index_type($type = null): View
    {
        $location_types = config('polanco.locations_type');
        $location_types = Arr::sort($location_types);

        $locations = \App\Models\Location::whereType($type)->orderBy('name')->get();

        return view('admin.locations.index', compact('locations', 'location_types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-location')]
    public function create(): View
    {
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
    #[Authorize('create-location')]
    public function store(StoreLocationRequest $request): RedirectResponse
    {
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
    #[Authorize('show-location')]
    public function show(int $id): View
    {
        $location = \App\Models\Location::findOrFail($id);
        $children = \App\Models\Location::whereParentId($id)->orderBy('name')->get();

        return view('admin.locations.show', compact('location', 'children'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-location')]
    public function edit(int $id): View
    {
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
    #[Authorize('update-location')]
    public function update(UpdateLocationRequest $request, int $id): RedirectResponse
    {
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
    #[Authorize('delete-location')]
    public function destroy(int $id): RedirectResponse
    {
        $location = \App\Models\Location::findOrFail($id);
        \App\Models\Location::destroy($id);

        flash('Location: '.$location->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
