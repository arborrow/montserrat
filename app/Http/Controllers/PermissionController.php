<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class PermissionController extends Controller
{
    #[Authorize('show-permission')]
    public function index(Request $request): View
    {
        $actions = [
            '' => 'N/A',
            'create' => 'create',
            'delete' => 'delete',
            'manage' => 'manage',
            'show' => 'show',
            'update' => 'update',
        ];
        // TODO: generate this list by getting a list of all the models on the project - email, phone do not have independent controllers (yet)
        $models = [
            '' => 'N/A',
            'address' => 'address',
            'asset' => 'asset',
            'asset-type' => 'asset-type',
            'attachment' => 'attachment',
            'contact' => 'contact',
            'department' => 'department',
            'donation' => 'donation',
            'donation-type' => 'donation-type',
            'email' => 'email',
            'group' => 'group',
            'location' => 'location',
            'mailgun' => 'mailgun',
            'note' => 'note',
            'payment' => 'payment',
            'permission' => 'permission',
            'phone' => 'phone',
            'registration' => 'registration',
            'relationship' => 'relationship',
            'reservation' => 'reservation',
            'retreat' => 'retreat',
            'role' => 'role',
            'room' => 'room',
            'snippet' => 'snippet',
            'squarespace-contribution' => 'squarespace-contribution',
            'squarespace-custom-form' => 'squarespace-custom-form',
            'squarespace-custom-form-field' => 'squarespace-custom-form-field',
            'squarespace-inventory' => 'squarespace-inventory',
            'squarespace-order' => 'squarespace-order',
            'stripe-charge' => 'stripe-charge',
            'stripe-payout' => 'stripe-payout',
            'touchpoint' => 'touchpoint',
            'uom' => 'uom',
            'user' => 'user',
            'website' => 'website',

        ];
        if (empty($request->input('term'))) {
            $term = $request->input('action').'-'.$request->input('model');
        } else {
            $term = $request->input('term');
        }
        if (empty($term)) {
            $permissions = \App\Models\Permission::orderBy('name')->get();
        } else {
            $permissions = \App\Models\Permission::orderBy('name')->where('name', 'like', '%'.$term.'%')->get();
        }

        return view('admin.permissions.index', compact('permissions', 'actions', 'models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-permission')]
    public function create(): View
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-permission')]
    public function store(Request $request): RedirectResponse
    {
        $permission = new \App\Models\Permission;
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        flash('Permission: <a href="'.url('/admin/permission/'.$permission->id).'">'.$permission->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('show-permission')]
    public function show(int $id): View
    {
        $permission = \App\Models\Permission::with('roles.users')->findOrFail($id);
        $roles = \App\Models\Role::orderBy('name')->pluck('name', 'id');

        return view('admin.permissions.show', compact('permission', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-permission')]
    public function edit(int $id): View
    {
        $permission = \App\Models\Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-permission')]
    public function update(Request $request, int $id): RedirectResponse
    {
        $permission = \App\Models\Permission::findOrFail($request->input('id'));
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        flash('Permission: <a href="'.url('/admin/permission/'.$permission->id).'">'.$permission->name.'</a> updated')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete-permission')]
    public function destroy(int $id): RedirectResponse
    {
        $permission = \App\Models\Permission::findOrFail($id);

        \App\Models\Permission::destroy($id);

        flash('Permission: '.$permission->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }

    #[Authorize('update-permission')]
    public function update_roles(Request $request): RedirectResponse
    {
        Gate::authorize('update-role');
        $permission = \App\Models\Permission::findOrFail($request->input('id'));
        $permission->roles()->detach();
        $permission->roles()->sync($request->input('roles'));

        flash('Role assignments for permission: <a href="'.url('/admin/permission/'.$permission->id).'">'.$permission->name.'</a> updated')->success();

        return Redirect::action([self::class, 'index']);
    }
}
