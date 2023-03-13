<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
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
    public function index(): View
    {
        $this->authorize('show-group');
        $groups = \App\Models\Group::whereIsActive(1)->orderBy('name')->with('members')->get();
        foreach ($groups as $group) {
            $group->count = $group->members()->count();
        }

        return view('groups.index', compact('groups'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $this->authorize('create-group');

        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request): RedirectResponse
    {
        $this->authorize('create-group');

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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): View
    {
        $this->authorize('show-group');
        $group = \App\Models\Group::findOrFail($id);
        $members = \App\Models\Contact::whereHas('groups', function ($query) use ($id) {
            $query->whereGroupId($id)->whereStatus('Added');
        })->orderby('sort_name')->get();

        return view('groups.show', compact('group', 'members')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id): View
    {
        $this->authorize('update-group');
        $group = \App\Models\Group::findOrFail($id);

        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-group');

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

        //return Redirect::action([\App\Http\Controllers\GroupController::class, 'index']);//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-group');

        $group = \App\Models\Group::findOrFail($id);

        \App\Models\Group::destroy($id);

        flash('Group: '.$group->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
