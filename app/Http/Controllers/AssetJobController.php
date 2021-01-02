<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetJobRequest;
use App\Http\Requests\UpdateAssetJobRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;

class AssetJobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-asset-job');

        $asset_jobs = \App\Models\AssetJob::orderBy('scheduled_date')->get();

        return view('asset_jobs.index',compact('asset_jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-asset-job');

        $asset_tasks = \App\Models\AssetTask::orderBy('title')->pluck('title', 'id');

        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id')->toArray();

        $status = config('polanco.asset_job_status');
        // dd($asset_tasks,$staff,$status);
        return view('asset_jobs.create', compact('asset_tasks', 'staff', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetJobRequest $request)
    {
        $this->authorize('create-asset-job');

        $asset_job = new \App\Models\AssetJob;

        // General info
        $asset_job->asset_task_id = $request->input('asset_task_id');
        $asset_job->assigned_to_id = $request->input('assigned_to_id');
        $asset_job->status = $request->input('status');

        // Dates
        $asset_job->scheduled_date = $request->input('scheduled_date');
        $asset_job->start_date = $request->input('start_date');
        $asset_job->end_date = $request->input('end_date');

        // Labor & materials
        $asset_job->actual_labor = $request->input('actual_labor');
        $asset_job->actual_labor_cost = $request->input('actual_labor_cost');
        $asset_job->additional_materials= $request->input('additional_materials');
        $asset_job->actual_material_cost = $request->input('actual_material_cost');

        // Notes
        $asset_job->note = $request->input('note');
        $asset_job->tag = $request->input('tag');

        $asset_job->save();

        flash('Asset job #: <a href="'.url('/asset_job/'.$asset_job->id).'">'.$asset_job->id.'</a> added')->success();

        // TODO: consider where best to redirect - possible to asset task or the asset itself
        return Redirect::action('AssetJobController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-asset-job');

        $asset_job = \App\Models\AssetJob::findOrFail($id);

        return view('asset_jobs.show', compact('asset_job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-asset');

        $asset_job = \App\Models\AssetJob::findOrFail($id);

        $asset_tasks = \App\Models\AssetTask::orderBy('title')->pluck('title', 'id');

        $staff = \App\Models\Contact::with('groups')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.staff'));
        })->orderBy('sort_name')->pluck('sort_name', 'id')->toArray();

        $status = config('polanco.asset_job_status');

        if (isset($asset_job->assigned_to_id)) {
            if (! Arr::has($staff, $asset_job->assigned_to_id)) {
                $staff[$asset_job->assigned_to_id] = $asset_job->assigned_to->sort_name.' (former)';
                asort($staff);
            }
        }

        return view('asset_jobs.edit', compact('asset_job', 'asset_tasks', 'staff', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssetJobRequest $request, $id)
    {
        $this->authorize('update-asset-job');

        $asset_job = \App\Models\AssetJob::findOrFail($id);

        // General info
        $asset_job->asset_task_id = $request->input('asset_task_id');
        $asset_job->assigned_to_id = $request->input('assigned_to_id');
        $asset_job->status = $request->input('status');

        // Dates
        $asset_job->scheduled_date = $request->input('scheduled_date');
        $asset_job->start_date = $request->input('start_date');
        $asset_job->end_date = $request->input('end_date');

        // Labor & materials
        $asset_job->actual_labor = $request->input('actual_labor');
        $asset_job->actual_labor_cost = $request->input('actual_labor_cost');
        $asset_job->additional_materials= $request->input('additional_materials');
        $asset_job->actual_material_cost = $request->input('actual_material_cost');

        // Notes
        $asset_job->note = $request->input('note');
        $asset_job->tag = $request->input('tag');

        $asset_job->save();
        
        //TODO: implement on asset_job edit blade
        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('attachment'), 'asset_job', $asset_job->id, 'attachment', $description);
        }

        flash('Asset job #<a href="'.url('/asset_job/'.$asset_job->id).'">'.$asset_job->id.'</a> updated')->success();

        return Redirect::action('AssetJobController@show', $asset_job->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-asset-job');
        $asset_job = \App\Models\AssetJob::findOrFail($id);

        \App\Models\AssetJob::destroy($id);
        flash('Asset job #'.$asset_job->id.' deleted')->warning()->important();
        // consider where to redirect to Asset, Asset Task, or Asset Job Index - I'm inclined toward asset_task
        return Redirect::action('AssetJobController@index');
    }
}
