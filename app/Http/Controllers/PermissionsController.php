<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PermissionsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        if ('cli' != php_sapi_name()) {
            $this->authorize('show-admin-menu');
        }
        
        
    }
    
    public function index()
    {
        //
        $permissions = \montserrat\Permission::orderBy('name')->get();
        return view('admin.permissions.index',compact('permissions'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        return view('admin.permissions.create');  

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    $permission = new \montserrat\Permission;
    $permission->name= $request->input('name');
    $permission->display_name= $request->input('display_name');
    $permission->description = $request->input('description');
    
    $permission->save();
    
    return Redirect::action('PermissionsController@index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $permission = \montserrat\Permission::with('roles')->findOrFail($id);
        $roles = \montserrat\Role::pluck('name','id');
        
        return view('admin.permissions.show',compact('permission','roles'));//

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $permission = \montserrat\Permission::findOrFail($id);
        
        return view('admin.permissions.edit',compact('permission'));//

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
        //
        $permission = \montserrat\Permission::findOrFail($request->input('id'));
    
        $permission->name= $request->input('name');
        $permission->display_name= $request->input('display_name');
        $permission->description= $request->input('description');

        $permission->save();
    
    return Redirect::action('PermissionsController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        \montserrat\Permission::destroy($id);
       return Redirect::action('PermissionsController@index');
    
    }
    public function update_roles(Request $request) {
        $permission = \montserrat\Permission::findOrFail($request->input('id'));
        $permission->roles()->detach();
        $permission->roles()->sync($request->input('roles'));
    
        return Redirect::action('PermissionsController@index');
    }
    
}
