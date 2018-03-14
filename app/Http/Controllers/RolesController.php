<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class RolesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    public function index()
    {
        $this->authorize('show-role');
        $roles = \App\Role::orderBy('name')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-role');
        return view('admin.roles.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-role');

        $role = new \App\Role;
        $role->name= $request->input('name');
        $role->display_name= $request->input('display_name');
        $role->description = $request->input('description');

        $role->save();

        return Redirect::action('RolesController@index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-role');
        
        $role = \App\Role::with('users', 'permissions')->findOrFail($id);
        $permissions = \App\Permission::orderBy('name')->pluck('name', 'id');
        $users = \App\User::orderBy('name')->pluck('name', 'id');
        
        return view('admin.roles.show', compact('role', 'permissions', 'users'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-role');
        
        $role = \App\Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));//
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
        $this->authorize('update-role');
        
        $role = \App\Role::findOrFail($request->input('id'));
        $role->name= $request->input('name');
        $role->display_name= $request->input('display_name');
        $role->description= $request->input('description');
        $role->save();
    
        return Redirect::action('RolesController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-role');
        
        \App\Role::destroy($id);
        return Redirect::action('RolesController@index');
    }

    public function update_permissions(Request $request)
    {
        $role = \App\Role::findOrFail($request->input('id'));
        $role->permissions()->detach();
        $role->permissions()->sync($request->input('permissions'));
    
        return Redirect::action('RolesController@index');
    }
    public function update_users(Request $request)
    {
        $role = \App\Role::findOrFail($request->input('id'));
        $role->users()->detach();
        $role->users()->sync($request->input('users'));
    
        return Redirect::action('RolesController@index');
    }
}
