<?php

namespace App\Http\Controllers;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-audit');
        $users = \App\Models\User::with('user')->orderBy('name')->pluck('name', 'id');
        $audits = \App\Models\Audit::with('user')->orderBy('created_at', 'DESC')->paginate(25,['*'],'audits');

        return view('admin.audits.index', compact('audits', 'users'));
    }

    public function index_type($user_id = null)
    {
        $this->authorize('show-audit');
        $users = \App\Models\User::with('user')->orderBy('name')->pluck('name', 'id');
        $audits = \App\Models\Audit::with('user')->whereUserId($user_id)->orderBy('created_at', 'DESC')->paginate(25,['*'],'audits');

        return view('admin.audits.index', compact('audits', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // cannot manually create audits
        $this->authorize('create-audit');
        flash('Manually creating an audit record is not allowed')->warning();

        return Redirect::action('AuditController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // cannot manually create audits
        $this->authorize('create-audit');
        flash('Manually storing an audit record is not allowed')->warning();

        return Redirect::action('AuditController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-audit');

        $audit = \App\Models\Audit::findOrFail($id);
        $old_values = collect($audit->old_values);
        $new_values = collect($audit->new_values);

        return view('admin.audits.show', compact('audit', 'old_values', 'new_values'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // cannot manually edit audits
        $this->authorize('update-audit');
        flash('Manually editing an audit record is not allowed')->warning();

        return Redirect::action('AuditController@index');
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
        // cannot manually edit audits
        $this->authorize('update-audit');
        flash('Manually updating an audit record is not allowed')->warning();

        return Redirect::action('AuditController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // cannot manually destroy audits
        $this->authorize('delete-audit');
        flash('Manually destroying an audit record is not allowed')->warning();

        return Redirect::action('AuditController@index');
    }
}
