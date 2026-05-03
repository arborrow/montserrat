<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuditSearchRequest;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[Authorize('show-audit')]
    public function index(): View
    {
        $users = \App\Models\User::with('user')->orderBy('name')->pluck('name', 'id');
        $audits = \App\Models\Audit::with('user')->orderBy('created_at', 'DESC')->paginate(25, ['*'], 'audits');

        return view('admin.audits.index', compact('audits', 'users'));
    }

    #[Authorize('show-audit')]
    public function index_type($user_id = null): View
    {
        $users = \App\Models\User::with('user')->orderBy('name')->pluck('name', 'id');
        $audits = \App\Models\Audit::with('user')->whereUserId($user_id)->orderBy('created_at', 'DESC')->paginate(25, ['*'], 'audits');

        return view('admin.audits.index', compact('audits', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-audit')]
    public function create(): RedirectResponse
    {
        // cannot manually create audits
        flash('Manually creating an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-audit')]
    public function store(Request $request): RedirectResponse
    {
        // cannot manually create audits
        flash('Manually storing an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('show-audit')]
    public function show(int $id): View
    {
        $audit = \App\Models\Audit::findOrFail($id);
        $old_values = collect($audit->old_values);
        $new_values = collect($audit->new_values);

        return view('admin.audits.show', compact('audit', 'old_values', 'new_values'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-audit')]
    public function edit(int $id): RedirectResponse
    {
        // cannot manually edit audits
        flash('Manually editing an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-audit')]
    public function update(Request $request, int $id): RedirectResponse
    {
        // cannot manually edit audits
        flash('Manually updating an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete-audit')]
    public function destroy(int $id): RedirectResponse
    {
        // cannot manually destroy audits
        flash('Manually destroying an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    #[Authorize('show-audit')]
    public function search(): View
    {
        $users = User::whereProvider('google')->pluck('name', 'id');
        $users->prepend('N/A', '');

        $models = Audit::where('auditable_type', 'LIKE', '%Models%')->groupBy('auditable_type')->orderBy('auditable_type')->get()->pluck('model_name', 'auditable_type');
        $models->prepend('N/A', '');
        // dd($models);
        $actions = [null => 'N/A', 'created' => 'created', 'deleted' => 'deleted', 'updated' => 'updated'];

        return view('admin.audits.search', compact('users', 'models', 'actions'));
    }

    #[Authorize('show-audit')]
    public function results(AuditSearchRequest $request): View
    {
        if (! empty($request)) {
            $audits = Audit::filtered($request)->orderByDesc('created_at')->paginate(25, ['*'], 'audits');
            $audits->appends($request->except('page'));
        } else {
            $audits = Audit::orderByDesc('created_at')->paginate(25, ['*'], 'audits');
        }

        return view('admin.audits.results', compact('audits'));
    }
}
