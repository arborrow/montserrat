<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class UserController extends Controller
{
    #[Authorize('show-role')]
    public function index(): View
    {
        $users = \App\Models\User::orderBy('name')->with('roles.permissions')->paginate(25, ['*'], 'users');

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-role')]
    public function create(): RedirectResponse
    {
        flash('Users cannot be created directly by the controller. Users are only created after successful authentication')->error();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-role')]
    public function store(Request $request): RedirectResponse
    {
        flash('Users cannot be stored directly by the controller. Users are only created after successful authentication.')->error();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('show-role')]
    public function show(int $id): View
    {
        $user = \App\Models\User::with('roles')->findOrFail($id);

        return view('admin.users.show', compact('user')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-role')]
    public function edit(int $id): RedirectResponse
    {
        flash('Users cannot be edited directly by the controller. Users are managed by Google authentication.')->error();

        return Redirect::action([self::class, 'show'], $id);
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-role')]
    public function update(Request $request, int $id): RedirectResponse
    {
        flash('Users cannot be updated directly by the controller. User profiles are managed by Google authentication.')->error();

        return Redirect::action([self::class, 'show'], $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete-role')]
    public function destroy(int $id): RedirectResponse
    {
        flash('Users cannot be deleted directly by the controller. Users are managed by Google authentication.')->error();

        return Redirect::action([self::class, 'show'], $id);
    }
}
