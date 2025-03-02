<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('show-group');
        $groups = \App\Models\Group::whereIsActive(1)->orderBy('name')->with('members')->get();
        foreach ($groups as $group) {
            $group->count = $group->members()->count();
        }

        return view('groups.index', compact('groups'));   //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create-group');

        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request): RedirectResponse
    {
        Gate::authorize('create-group');

        $group = new \App\Models\Group;
        $group->name = $request->input('name');
        $group->title = $request->input('title');
        $group->description = $request->input('description');
        $group->is_active = $request->input('is_active');
        $group->is_hidden = $request->input('is_hidden');
        $group->is_reserved = $request->input('is_reserved');

        $group->save();

        flash('Group: <a href="'.url('/group/'.$group->id).'">'.$group->name.'</a> added')->success();

        return Redirect::action([self::class, 'show'], $group->id); //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        Gate::authorize('show-group');
        $group = \App\Models\Group::findOrFail($id);
        $members = \App\Models\Contact::whereHas('groups', function ($query) use ($id) {
            $query->whereGroupId($id)->whereStatus('Added');
        })->orderby('sort_name')->get();

        return view('groups.show', compact('group', 'members')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        Gate::authorize('update-group');
        $group = \App\Models\Group::findOrFail($id);

        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, int $id): RedirectResponse
    {
        Gate::authorize('update-group');

        $group = \App\Models\Group::findOrFail($id);
        $group->name = $request->input('name');
        $group->title = $request->input('title');
        $group->description = $request->input('description');
        $group->is_active = $request->input('is_active');
        $group->is_hidden = $request->input('is_hidden');
        $group->is_reserved = $request->input('is_reserved');

        $group->save();

        flash('Group: <a href="'.url('/group/'.$group->id).'">'.$group->name.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $id);

        // return Redirect::action([\App\Http\Controllers\GroupController::class, 'index']);//
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        Gate::authorize('delete-group');

        $group = \App\Models\Group::findOrFail($id);

        \App\Models\Group::destroy($id);

        flash('Group: '.$group->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
