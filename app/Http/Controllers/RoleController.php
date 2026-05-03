<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class RoleController extends Controller
{
    #[Authorize('show-role')]
    public function index(): View
    {
        $roles = \App\Models\Role::orderBy('name')->get();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-role')]
    public function create(): View
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-role')]
    public function store(Request $request): RedirectResponse
    {
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
     */
    #[Authorize('show-role')]
    public function show(int $id): View
    {
        $role = \App\Models\Role::with('users', 'permissions')->findOrFail($id);
        $permissions = \App\Models\Permission::orderBy('name')->pluck('name', 'id');
        $users = \App\Models\User::orderBy('name')->pluck('name', 'id');

        return view('admin.roles.show', compact('role', 'permissions', 'users')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-role')]
    public function edit(int $id): View
    {
        $role = \App\Models\Role::findOrFail($id);

        return view('admin.roles.edit', compact('role')); //
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-role')]
    public function update(Request $request, int $id): RedirectResponse
    {
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
     */
    #[Authorize('delete-role')]
    public function destroy(int $id): RedirectResponse
    {
        $role = \App\Models\Role::findOrFail($id);
        \App\Models\Role::destroy($id);

        flash('Role: '.$role->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }

    #[Authorize('update-role')]
    public function update_permissions(Request $request): RedirectResponse
    {
        $role = \App\Models\Role::findOrFail($request->input('id'));
        $role->permissions()->detach();
        $role->permissions()->sync($request->input('permissions'));

        flash('Permissions successfully updated for role: <a href="'.url('/admin/role/'.$role->id).'">'.$role->name.'</a>')->success();

        return Redirect::action([self::class, 'index']);
    }

    #[Authorize('update-role')]
    public function update_users(Request $request): RedirectResponse
    {
        $role = \App\Models\Role::findOrFail($request->input('id'));
        $role->users()->detach();
        $role->users()->sync($request->input('users'));

        flash('Users successfully updated for role: <a href="'.url('/admin/role/'.$role->id).'">'.$role->name.'</a>')->success();

        return Redirect::action([self::class, 'index']);
    }
}
