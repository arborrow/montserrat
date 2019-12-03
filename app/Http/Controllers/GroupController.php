<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;

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
    public function index()
    {
        $this->authorize('show-group');
        $groups = \App\Group::whereIsActive(1)->orderBy('name')->with('members')->get();
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
    public function create()
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
    public function store(Request $request)
    {
        $this->authorize('create-group');
        $this->validate($request, [
            'name' => 'required|unique:group',
            'title' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_hidden' => 'integer|min:0|max:1',
            'is_reserved' => 'integer|min:0|max:1',
        ]);

        $group = new \App\Group;
        $group->name = $request->input('name');
        $group->title = $request->input('title');
        $group->description = $request->input('description');
        $group->is_active = $request->input('is_active');
        $group->is_hidden = $request->input('is_hidden');
        $group->is_reserved = $request->input('is_reserved');

        $group->save();

        return Redirect::action('GroupController@show', $group->id); //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-group');
        $group = \App\Group::findOrFail($id);
        $members = \App\Contact::whereHas('groups', function ($query) use ($id) {
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
    public function edit($id)
    {
        $this->authorize('update-group');
        $group = \App\Group::findOrFail($id);

        return view('groups.edit', compact('group'));
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
        $this->authorize('update-group');
        $this->validate($request, [
            'name' => 'required',
            'title' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_hidden' => 'integer|min:0|max:1',
            'is_reserved' => 'integer|min:0|max:1',
        ]);

        $group = \App\Group::findOrFail($request->input('id'));
        $group->name = $request->input('name');
        $group->title = $request->input('title');
        $group->description = $request->input('description');
        $group->is_active = $request->input('is_active');
        $group->is_hidden = $request->input('is_hidden');
        $group->is_reserved = $request->input('is_reserved');

        $group->save();

        return redirect()->intended('group/'.$group->id);

        //return Redirect::action('GroupController@index');//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-group');
        \App\Group::destroy($id);

        return Redirect::action('GroupController@index');
    }
}
