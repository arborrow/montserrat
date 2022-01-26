<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-role');
        $users = \App\Models\User::orderBy('name')->with('roles.permissions')->paginate(25, ['*'], 'users');

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-role');
        flash('Users cannot be created directly by the controller. Users are only created after successful authentication')->error();

        return Redirect::action('UserController@index');
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
        flash('Users cannot be stored directly by the controller. Users are only created after successful authentication.')->error();

        return Redirect::action('UserController@index');
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

        $user = \App\Models\User::with('roles')->findOrFail($id);

        return view('admin.users.show', compact('user')); //
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
        flash('Users cannot be edited directly by the controller. Users are managed by Google authentication.')->error();

        return Redirect::action('UserController@show', $id);
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
        flash('Users cannot be updated directly by the controller. User profiles are managed by Google authentication.')->error();

        return Redirect::action('UserController@show', $id);
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
        flash('Users cannot be deleted directly by the controller. Users are managed by Google authentication.')->error();

        return Redirect::action('UserController@show', $id);
    }
}
