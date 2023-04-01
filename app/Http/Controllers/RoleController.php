<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $this->authorize('show-role');
        $roles = \App\Models\Role::orderBy('name')->get();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $this->authorize('create-role');

        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create-role');

        $role = new \App\Models\Role;
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');

        $role->save();

        flash('Role: <a href="'.url('/admin/role/'.$role->id).'">'.$role->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): View
    {
        $this->authorize('show-role');

        $role = \App\Models\Role::with('users', 'permissions')->findOrFail($id);
        $permissions = \App\Models\Permission::orderBy('name')->pluck('name', 'id');
        $users = \App\Models\User::orderBy('name')->pluck('name', 'id');

        return view('admin.roles.show', compact('role', 'permissions', 'users')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id): View
    {
        $this->authorize('update-role');

        $role = \App\Models\Role::findOrFail($id);

        return view('admin.roles.edit', compact('role')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->authorize('update-role');

        $role = \App\Models\Role::findOrFail($request->input('id'));
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        flash('Role: <a href="'.url('/admin/role/'.$role->id).'">'.$role->name.'</a> updated')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-role');

        $role = \App\Models\Role::findOrFail($id);
        \App\Models\Role::destroy($id);

        flash('Role: '.$role->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }

    public function update_permissions(Request $request): RedirectResponse
    {
        $this->authorize('update-role');
        $role = \App\Models\Role::findOrFail($request->input('id'));
        $role->permissions()->detach();
        $role->permissions()->sync($request->input('permissions'));

        flash('Permissions successfully updated for role: <a href="'.url('/admin/role/'.$role->id).'">'.$role->name.'</a>')->success();

        return Redirect::action([self::class, 'index']);
    }

    public function update_users(Request $request): RedirectResponse
    {
        $this->authorize('update-role');
        $role = \App\Models\Role::findOrFail($request->input('id'));
        $role->users()->detach();
        $role->users()->sync($request->input('users'));

        flash('Users successfully updated for role: <a href="'.url('/admin/role/'.$role->id).'">'.$role->name.'</a>')->success();

        return Redirect::action([self::class, 'index']);
    }
}
