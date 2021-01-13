<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetTaskRequest;
use App\Http\Requests\UpdateAssetTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AssetTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-asset-task');

        $asset_tasks = \App\Models\AssetTask::with('asset')->orderBy('title')->get();

        return view('asset_tasks.index', compact('asset_tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($asset_id = 0)
    {
        $this->authorize('create-asset-task');

        // if creating a task for a particular asset (default behavior from asset.show blade) then no need to get long list of assets to choose from
        if ( isset($asset_id) && $asset_id > 0) {
            $assets = \App\Models\Asset::whereId($asset_id)->pluck('name','id');
            // dd($asset_id, $assets);
        } else {
            $assets = \App\Models\Asset::orderBy('name')->pluck('name', 'id');
            $assets->prepend('N/A', '');
        }

        $vendors = \App\Models\Contact::vendors()->orderBy('organization_name')->pluck('organization_name', 'id');
        $vendors->prepend('N/A', '');

        $frequencies = config('polanco.asset_task_frequency');
        $priorities = array_flip(config('polanco.priority'));

        return view('asset_tasks.create', compact('assets','frequencies', 'priorities','vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetTaskRequest $request)
    {
        $this->authorize('create-asset-task');

        $asset_task = new \App\Models\AssetTask;

        $asset_task->asset_id = $request->input('asset_id');
        $asset_task->title = $request->input('title');
        $asset_task->start_date = $request->input('start_date');
        $asset_task->scheduled_until_date = $request->input('scheduled_until_date');
        $asset_task->frequency_interval = $request->input('frequency_interval');
        $asset_task->frequency = $request->input('frequency');
        $asset_task->frequency_month = $request->input('frequency_month');
        $asset_task->frequency_day = $request->input('frequency_day');
        $asset_task->frequency_time = $request->input('frequency_time');
        $asset_task->description = $request->input('description');
        $asset_task->priority_id = $request->input('priority_id');
        $asset_task->needed_labor_minutes = $request->input('needed_labor_minutes');
        $asset_task->estimated_labor_cost = $request->input('estimated_labor_cost');
        $asset_task->needed_material = $request->input('needed_material');
        $asset_task->estimated_material_cost = $request->input('estimated_material_cost');
        $asset_task->vendor_id = $request->input('vendor_id');
        $asset_task->category = $request->input('category');
        $asset_task->tag = $request->input('tag');

        $asset_task->save();

        flash('Asset Task: <a href="'.url('/asset_task/'.$asset_task->id).'">'. $asset_task->asset_name .': ' . $asset_task->title.'</a> added')->success();

        return Redirect::action('AssetTaskController@index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-asset-task');

        $asset_task = \App\Models\AssetTask::with('jobs')->findOrFail($id);
        $jobs_scheduled = \App\Models\AssetJob::whereAssetTaskId($id)->where('scheduled_date','>=',now())->orderBy('scheduled_date')->get();
        $jobs_past = \App\Models\AssetJob::whereAssetTaskId($id)->where('scheduled_date','<',now())->orderBy('scheduled_date')->get();

        return view('asset_tasks.show', compact('asset_task','jobs_scheduled','jobs_past'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-asset-task');

        $asset_task = \App\Models\AssetTask::findOrFail($id);

        $assets = \App\Models\Asset::orderBy('name')->pluck('name', 'id');
        $assets->prepend('N/A', '');

        $vendors = \App\Models\Contact::vendors()->orderBy('organization_name')->pluck('organization_name', 'id');
        $vendors->prepend('N/A', '');

        $frequencies = config('polanco.asset_task_frequency');
        $priorities = array_flip(config('polanco.priority'));

        return view('asset_tasks.edit', compact('asset_task', 'assets', 'vendors', 'frequencies', 'priorities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssetTaskRequest $request, $id)
    {
        $this->authorize('update-asset-task');

        $asset_task = \App\Models\AssetTask::findOrFail($id);

        $asset_task->asset_id = $request->input('asset_id');
        $asset_task->title = $request->input('title');
        $asset_task->start_date = $request->input('start_date');
        $asset_task->scheduled_until_date = $request->input('scheduled_until_date');
        $asset_task->frequency_interval = $request->input('frequency_interval');
        $asset_task->frequency = $request->input('frequency');
        $asset_task->frequency_month = $request->input('frequency_month');
        $asset_task->frequency_day = $request->input('frequency_day');
        $asset_task->frequency_time = $request->input('frequency_time');
        $asset_task->description = $request->input('description');
        $asset_task->priority_id = $request->input('priority_id');
        $asset_task->needed_labor_minutes = $request->input('needed_labor_minutes');
        $asset_task->estimated_labor_cost = $request->input('estimated_labor_cost');
        $asset_task->needed_material = $request->input('needed_material');
        $asset_task->estimated_material_cost = $request->input('estimated_material_cost');
        $asset_task->vendor_id = $request->input('vendor_id');
        $asset_task->category = $request->input('category');
        $asset_task->tag = $request->input('tag');

        $asset_task->save();


        flash('Asset Task: <a href="'.url('/asset_task/'.$asset_task->id).'">'.$asset_task->asset_name.': '.$asset_task->title.'</a> updated')->success();

        return Redirect::action('AssetTaskController@show', $asset_task->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-asset-task');
        $asset_task = \App\Models\AssetTask::findOrFail($id);

        \App\Models\AssetTask::destroy($id);
        flash('Asset Task: '.$asset_task->asset_name.': '.$asset_task->title.' deleted')->warning()->important();

        return Redirect::action('AssetTaskController@index');
    }
}
