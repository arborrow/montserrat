<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\AuditSearchRequest;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('show-audit');
        $users = \App\Models\User::with('user')->orderBy('name')->pluck('name', 'id');
        $audits = \App\Models\Audit::with('user')->orderBy('created_at', 'DESC')->paginate(25, ['*'], 'audits');

        return view('admin.audits.index', compact('audits', 'users'));
    }

    public function index_type($user_id = null): View
    {
        $this->authorize('show-audit');
        $users = \App\Models\User::with('user')->orderBy('name')->pluck('name', 'id');
        $audits = \App\Models\Audit::with('user')->whereUserId($user_id)->orderBy('created_at', 'DESC')->paginate(25, ['*'], 'audits');

        return view('admin.audits.index', compact('audits', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse
    {
        // cannot manually create audits
        $this->authorize('create-audit');
        flash('Manually creating an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // cannot manually create audits
        $this->authorize('create-audit');
        flash('Manually storing an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->authorize('show-audit');

        $audit = \App\Models\Audit::findOrFail($id);
        $old_values = collect($audit->old_values);
        $new_values = collect($audit->new_values);

        return view('admin.audits.show', compact('audit', 'old_values', 'new_values'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): RedirectResponse
    {
        // cannot manually edit audits
        $this->authorize('update-audit');
        flash('Manually editing an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        // cannot manually edit audits
        $this->authorize('update-audit');
        flash('Manually updating an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        // cannot manually destroy audits
        $this->authorize('delete-audit');
        flash('Manually destroying an audit record is not allowed')->warning();

        return Redirect::action([self::class, 'index']);
    }

    public function search(): View
    {
        $this->authorize('show-audit');

        $users = User::whereProvider('google')->pluck('name', 'id');
        $users->prepend('N/A', '');

        $models = Audit::where('auditable_type', 'LIKE', '%Models%')->groupBy('auditable_type')->orderBy('auditable_type')->get()->pluck('model_name', 'auditable_type');
        $models->prepend('N/A', '');
        //dd($models);
        $actions = [null => 'N/A', 'created' => 'created', 'deleted' => 'deleted', 'updated' => 'updated'];

        return view('admin.audits.search', compact('users', 'models', 'actions'));
    }

    public function results(AuditSearchRequest $request): View
    {
        $this->authorize('show-audit');
        if (! empty($request)) {
            $audits = Audit::filtered($request)->orderByDesc('created_at')->paginate(25, ['*'], 'audits');
            $audits->appends($request->except('page'));
        } else {
            $audits = Audit::orderByDesc('created_at')->paginate(25, ['*'], 'audits');
        }

        return view('admin.audits.results', compact('audits'));
    }
}
