<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreExportListRequest;
use App\Http\Requests\UpdateExportListRequest;

class ExportListController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-export-list');
        $export_lists = \App\ExportList::orderBy('label')->get();

        return view('admin.export_lists.index', compact('export_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-export-list');
        $export_list_types = config('polanco.export_list_types');

        return view('admin.export_lists.create', compact('export_list_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExportListRequest $request)
    {
        $this->authorize('create-export-list');

        $export_list = new \App\ExportList;
        $export_list->title = $request->input('title');
        $export_list->label = $request->input('label');
        $export_list->type = $request->input('type');
        $export_list->fields = $request->input('fields');
        $export_list->filters = $request->input('filters');
        $export_list->start_date = $request->input('start_date');
        $export_list->end_date = $request->input('end_date');
        $export_list->last_run_date = $request->input('last_run_date');
        $export_list->next_scheduled_date = $request->input('next_scheduled_date');

        $export_list->save();

        flash ('Export list: <a href="'. url('/admin/export_list/'.$export_list->id) . '">'.$export_list->label.'</a> added')->success();
        return Redirect::action('ExportListController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-export-list');

        $export_list = \App\ExportList::findOrFail($id);

        return view('admin.export_lists.show', compact('export_list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-export-list');

        $export_list = \App\ExportList::findOrFail($id);
        $export_list_types = config('polanco.export_list_types');

        return view('admin.export_lists.edit', compact('export_list','export_list_types')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExportListRequest $request, $id)
    {
        $this->authorize('update-export-list');

        $export_list = \App\ExportList::findOrFail($id);

        $export_list->title = $request->input('title');
        $export_list->label = $request->input('label');
        $export_list->type = $request->input('type');
        $export_list->fields = $request->input('fields');
        $export_list->filters = $request->input('filters');
        $export_list->start_date = $request->input('start_date');
        $export_list->end_date = $request->input('end_date');
        $export_list->last_run_date = $request->input('last_run_date');
        $export_list->next_scheduled_date = $request->input('next_scheduled_date');

        $export_list->save();

        flash ('Export list: <a href="'. url('/admin/export_list/'.$export_list->id) . '">'.$export_list->label.'</a> updated')->success();
        return Redirect::action('ExportListController@show',$export_list->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-export-list');
        $export_list = \App\ExportList::findOrFail($id);

        \App\ExportList::destroy($id);

        flash('Export list: '.$export_list->label . ' deleted')->warning()->important();
        return Redirect::action('ExportListController@index');
    }

}
