<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function index(): View
    {
        Gate::authorize('show-role');
        $users = \App\Models\User::orderBy('name')->with('roles.permissions')->paginate(25, ['*'], 'users');

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse
    {
        Gate::authorize('create-role');
        flash('Users cannot be created directly by the controller. Users are only created after successful authentication')->error();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create-role');
        flash('Users cannot be stored directly by the controller. Users are only created after successful authentication.')->error();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        Gate::authorize('show-role');

        $user = \App\Models\User::with('roles')->findOrFail($id);

        return view('admin.users.show', compact('user')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): RedirectResponse
    {
        Gate::authorize('update-role');
        flash('Users cannot be edited directly by the controller. Users are managed by Google authentication.')->error();

        return Redirect::action([self::class, 'show'], $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        Gate::authorize('update-role');
        flash('Users cannot be updated directly by the controller. User profiles are managed by Google authentication.')->error();

        return Redirect::action([self::class, 'show'], $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        Gate::authorize('delete-role');
        flash('Users cannot be deleted directly by the controller. Users are managed by Google authentication.')->error();

        return Redirect::action([self::class, 'show'], $id);
    }
}
