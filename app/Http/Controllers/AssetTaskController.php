<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetTaskRequest;
use App\Http\Requests\UpdateAssetTaskRequest;
// use App\Http\Requests\AssetTaskSearchRequest;
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

        $asset_task_types = \App\Models\AssetTaskType::active()->orderBy('label')->pluck('label', 'id');
        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');

        $asset_tasks = \App\Models\AssetTask::orderBy('name')->get();

        return view('asset_tasks.index', compact('asset_tasks', 'asset_task_types', 'locations'));
    }

/* Commenting out index filtering, search and replace methods
 
    public function index_type($type = null)
    {
        $this->authorize('show-asset-task');

        $asset_task_types = \App\Models\AssetTaskType::active()->orderBy('label')->pluck('label', 'id');
        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');

        $asset_tasks = \App\Models\AssetTask::whereAssetTaskTypeId($type)->orderBy('name')->get();

        return view('asset_tasks.index', compact('asset_tasks', 'asset_task_types', 'locations'));
    }

    public function index_location($location_id = null)
    {
        $this->authorize('show-asset-task');

        $asset_task_types = \App\Models\AssetTaskType::active()->orderBy('label')->pluck('label', 'id');
        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');

        $asset_tasks = \App\Models\AssetTask::whereLocationId($location_id)->orderBy('name')->get();

        return view('asset_tasks.index', compact('asset_tasks', 'asset_task_types', 'locations'));
    }

    public function search()
    {
        $this->authorize('show-asset-task');

        $asset_task_types = \App\Models\AssetTaskType::active()->orderBy('label')->pluck('label', 'id');
        $asset_task_types->prepend('N/A', '');

        $departments = \App\Models\Department::active()->orderBy('label')->pluck('label', 'id');
        $departments->prepend('N/A', '');

        // TODO: determine and set up various depreciation types
        $depreciation_types = [''=>'N/A'];

        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');
        $locations->prepend('N/A', '');

        $parents = \App\Models\AssetTask::active()->orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', '');

        $uoms_capacity = \App\Models\Uom::orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_capacity->prepend('N/A', '');

        $uoms_electric = \App\Models\Uom::electric()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_electric->prepend('N/A', '');

        $uoms_length = \App\Models\Uom::length()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_length->prepend('N/A', '');

        $uoms_time = \App\Models\Uom::time()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_time->prepend('N/A', '');

        $uoms_weight = \App\Models\Uom::weight()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_weight->prepend('N/A', '');

        $vendors = \App\Models\Contact::vendors()->orderBy('organization_name')->pluck('organization_name', 'id');
        $vendors->prepend('N/A', '');

        return view('asset_tasks.search', compact('asset_task_types', 'departments', 'depreciation_types', 'locations', 'parents', 'uoms_capacity', 'uoms_electric', 'uoms_length', 'uoms_time', 'uoms_weight', 'vendors'));
    }

    public function results(AssetTaskSearchRequest $request)
    {
        $this->authorize('show-asset-task');
        if (! empty($request)) {
            $asset_tasks = \App\Models\AssetTask::filtered($request)->orderBy('name')->paginate(100);
            $asset_tasks->appends($request->except('page'));
        } else {
            $asset_tasks = \App\Models\AssetTask::orderBy('name')->paginate(100);
        }

        return view('asset_tasks.results', compact('asset_tasks'));
    }
*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-asset-task');

        $asset_task_types = \App\Models\AssetTaskType::active()->orderBy('label')->pluck('label', 'id');
        $asset_task_types->prepend('N/A', '');

        $departments = \App\Models\Department::active()->orderBy('label')->pluck('label', 'id');
        $departments->prepend('N/A', '');

        $parents = \App\Models\AssetTask::active()->orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', '');

        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');
        $locations->prepend('N/A', '');

        $vendors = \App\Models\Contact::vendors()->orderBy('organization_name')->pluck('organization_name', 'id');
        $vendors->prepend('N/A', '');

        $uoms_electric = \App\Models\Uom::electric()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_electric->prepend('N/A', '');
        $uoms_length = \App\Models\Uom::length()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_length->prepend('N/A', '');
        $uoms_weight = \App\Models\Uom::weight()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_weight->prepend('N/A', '');
        $uoms_time = \App\Models\Uom::time()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_time->prepend('N/A', '');
        $uoms_capacity = \App\Models\Uom::orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_capacity->prepend('N/A', '');
        // TODO: determine and set up various depreciation types
        $depreciation_types = [''=>'N/A'];

        return view('asset_tasks.create', compact('asset_task_types', 'departments', 'parents', 'locations', 'vendors', 'uoms_electric', 'uoms_length', 'uoms_weight', 'uoms_capacity', 'uoms_time', 'depreciation_types'));
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
        //General info
        $asset_task->name = $request->input('name');
        $asset_task->asset_task_type_id = $request->input('asset_task_type_id');
        $asset_task->description = $request->input('description');

        $asset_task->manufacturer = $request->input('manufacturer');
        $asset_task->model = $request->input('model');
        $asset_task->serial_number = $request->input('serial_number');
        $asset_task->year = $request->input('year');

        $asset_task->location_id = ($request->input('location_id') > 0) ? $request->input('location_id') : null;
        $asset_task->department_id = ($request->input('department_id') > 0) ? $request->input('department_id') : null;
        $asset_task->parent_id = ($request->input('parent_id') > 0) ? $request->input('parent_id') : null;
        $asset_task->status = $request->input('status');
        $asset_task->remarks = $request->input('remarks');
        $asset_task->is_active = $request->input('is_active');

        //Service information
        $asset_task->manufacturer_id = ($request->input('manufacturer_id') > 0) ? $request->input('manufacturer_id') : null;
        $asset_task->vendor_id = ($request->input('vendor_id') > 0) ? $request->input('vendor_id') : null;

        //Power specs
        $asset_task->power_line_voltage = $request->input('power_line_voltage');
        $asset_task->power_line_voltage_uom_id = ($request->input('power_line_voltage_uom_id') > 0) ? $request->input('power_line_voltage_uom_id') : null;
        $asset_task->power_phase_voltage = $request->input('power_phase_voltage');
        $asset_task->power_phase_voltage_uom_id = ($request->input('power_phase_voltage_uom_id') > 0) ? $request->input('power_phase_voltage_uom_id') : null;
        $asset_task->power_phases = $request->input('power_phases');
        $asset_task->power_amp = $request->input('power_amp');
        $asset_task->power_amp_uom_id = ($request->input('power_amp_uom_id') > 0) ? $request->input('power_amp_uom_id') : null;

        //Physical specs
        $asset_task->length = $request->input('length');
        $asset_task->length_uom_id = ($request->input('length_uom_id') > 0) ? $request->input('length_uom_id') : null;
        $asset_task->width = $request->input('width');
        $asset_task->width_uom_id = ($request->input('width_uom_id') > 0) ? $request->input('width_uom_id') : null;
        $asset_task->height = $request->input('height');
        $asset_task->height_uom_id = ($request->input('height_uom_id') > 0) ? $request->input('height_uom_id') : null;
        $asset_task->weight = $request->input('weight');
        $asset_task->weight_uom_id = ($request->input('weight_uom_id') > 0) ? $request->input('weight_uom_id') : null;
        $asset_task->capacity = $request->input('capacity');
        $asset_task->capacity_uom_id = ($request->input('capacity_uom_id') > 0) ? $request->input('capacity_uom_id') : null;

        //Purchase info
        $asset_task->purchase_date = $request->input('purchase_date');
        $asset_task->purchase_price = $request->input('purchase_price');
        $asset_task->life_expectancy = $request->input('life_expectancy');
        $asset_task->life_expectancy_uom_id = ($request->input('life_expectancy_uom_id') > 0) ? $request->input('life_expectancy_uom_id') : null;
        $asset_task->start_date = $request->input('start_date');
        $asset_task->end_date = $request->input('end_date');
        $asset_task->replacement_id = ($request->input('replacement_id') > 0) ? $request->input('replacement_id') : null;

        //Warranty info
        $asset_task->warranty_start_date = $request->input('warranty_start_date');
        $asset_task->warranty_end_date = $request->input('warranty_end_date');

        //Depreciation info
        $asset_task->depreciation_start_date = $request->input('depreciation_start_date');
        $asset_task->depreciation_end_date = $request->input('depreciation_end_date');
        $asset_task->depreciation_type_id = ($request->input('depreciation_type_id') > 0) ? $request->input('depreciation_type_id') : null;
        $asset_task->depreciation_rate = $request->input('depreciation_rate');
        $asset_task->depreciation_value = $request->input('depreciation_value');
        $asset_task->depreciation_time = $request->input('depreciation_time');
        $asset_task->depreciation_time_uom_id = ($request->input('depreciation_time_uom_id') > 0) ? $request->input('depreciation_time_uom_id') : null;

        $asset_task->save();

        if (null !== $request->file('asset_task_photo')) {
            $description = 'Photo of '.$asset_task->name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('asset_task_photo'), 'asset_task', $asset_task->id, 'asset_task_photo', $description);
        }

        flash('AssetTask: <a href="'.url('/asset_task/'.$asset_task->id).'">'.$asset_task->name.'</a> added')->success();

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

        $asset_task = \App\Models\AssetTask::findOrFail($id);
        $files = \App\Models\Attachment::whereEntity('asset_task')->whereEntityId($asset_task->id)->whereFileTypeId(config('polanco.file_type.asset_task_attachment'))->get();

        return view('asset_tasks.show', compact('asset_task', 'files'));
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

        $asset_task_types = \App\Models\AssetTaskType::active()->orderBy('label')->pluck('label', 'id');
        $asset_task_types->prepend('N/A', '');

        $departments = \App\Models\Department::active()->orderBy('label')->pluck('label', 'id');
        $departments->prepend('N/A', '');

        $parents = \App\Models\AssetTask::active()->orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', '');

        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');
        $locations->prepend('N/A', '');

        $vendors = \App\Models\Contact::vendors()->orderBy('organization_name')->pluck('organization_name', 'id');
        $vendors->prepend('N/A', '');

        $uoms_electric = \App\Models\Uom::electric()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_electric->prepend('N/A', '');
        $uoms_length = \App\Models\Uom::length()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_length->prepend('N/A', '');
        $uoms_weight = \App\Models\Uom::weight()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_weight->prepend('N/A', '');
        $uoms_time = \App\Models\Uom::time()->orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_time->prepend('N/A', '');
        $uoms_capacity = \App\Models\Uom::orderBy('unit_name')->pluck('unit_name', 'id');
        $uoms_capacity->prepend('N/A', '');
        // TODO: determine and set up various depreciation types
        $depreciation_types = [0=>'N/A'];

        return view('asset_tasks.edit', compact('asset_task', 'asset_task_types', 'departments', 'parents', 'locations', 'vendors', 'uoms_electric', 'uoms_length', 'uoms_weight', 'uoms_time', 'uoms_capacity', 'depreciation_types')); //
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

        //General info
        $asset_task->name = $request->input('name');
        $asset_task->asset_task_type_id = $request->input('asset_task_type_id');
        $asset_task->description = $request->input('description');

        $asset_task->manufacturer = $request->input('manufacturer');
        $asset_task->model = $request->input('model');
        $asset_task->serial_number = $request->input('serial_number');
        $asset_task->year = $request->input('year');

        $asset_task->location_id = ($request->input('location_id') > 0) ? $request->input('location_id') : null;
        $asset_task->department_id = ($request->input('department_id') > 0) ? $request->input('department_id') : null;
        $asset_task->parent_id = ($request->input('parent_id') > 0) ? $request->input('parent_id') : null;
        $asset_task->status = $request->input('status');
        $asset_task->remarks = $request->input('remarks');
        $asset_task->is_active = $request->input('is_active');

        //Service information
        $asset_task->manufacturer_id = ($request->input('manufacturer_id') > 0) ? $request->input('manufacturer_id') : null;
        $asset_task->vendor_id = ($request->input('vendor_id') > 0) ? $request->input('vendor_id') : null;

        //Power specs
        $asset_task->power_line_voltage = $request->input('power_line_voltage');
        $asset_task->power_line_voltage_uom_id = ($request->input('power_line_voltage_uom_id') > 0) ? $request->input('power_line_voltage_uom_id') : null;
        $asset_task->power_phase_voltage = $request->input('power_phase_voltage');
        $asset_task->power_phase_voltage_uom_id = ($request->input('power_phase_voltage_uom_id') > 0) ? $request->input('power_phase_voltage_uom_id') : null;
        $asset_task->power_phases = $request->input('power_phases');
        $asset_task->power_amp = $request->input('power_amp');
        $asset_task->power_amp_uom_id = ($request->input('power_amp_uom_id') > 0) ? $request->input('power_amp_uom_id') : null;

        //Physical specs
        $asset_task->length = $request->input('length');
        $asset_task->length_uom_id = ($request->input('length_uom_id') > 0) ? $request->input('length_uom_id') : null;
        $asset_task->width = $request->input('width');
        $asset_task->width_uom_id = ($request->input('width_uom_id') > 0) ? $request->input('width_uom_id') : null;
        $asset_task->height = $request->input('height');
        $asset_task->height_uom_id = ($request->input('height_uom_id') > 0) ? $request->input('height_uom_id') : null;
        $asset_task->weight = $request->input('weight');
        $asset_task->weight_uom_id = ($request->input('weight_uom_id') > 0) ? $request->input('weight_uom_id') : null;
        $asset_task->capacity = $request->input('capacity');
        $asset_task->capacity_uom_id = ($request->input('capacity_uom_id') > 0) ? $request->input('capacity_uom_id') : null;

        //Purchase info
        $asset_task->purchase_date = $request->input('purchase_date');
        $asset_task->purchase_price = $request->input('purchase_price');
        $asset_task->life_expectancy = $request->input('life_expectancy');
        $asset_task->life_expectancy_uom_id = ($request->input('life_expectancy_uom_id') > 0) ? $request->input('life_expectancy_uom_id') : null;
        $asset_task->start_date = $request->input('start_date');
        $asset_task->end_date = $request->input('end_date');
        $asset_task->replacement_id = ($request->input('replacement_id') > 0) ? $request->input('replacement_id') : null;

        //Warranty info
        $asset_task->warranty_start_date = $request->input('warranty_start_date');
        $asset_task->warranty_end_date = $request->input('warranty_end_date');

        //Depreciation info
        $asset_task->depreciation_start_date = $request->input('depreciation_start_date');
        $asset_task->depreciation_end_date = $request->input('depreciation_end_date');
        $asset_task->depreciation_type_id = ($request->input('depreciation_type_id') > 0) ? $request->input('depreciation_type_id') : null;
        $asset_task->depreciation_rate = $request->input('depreciation_rate');
        $asset_task->depreciation_value = $request->input('depreciation_value');
        $asset_task->depreciation_time = $request->input('depreciation_time');
        $asset_task->depreciation_time_uom_id = ($request->input('depreciation_time_uom_id') > 0) ? $request->input('depreciation_time_uom_id') : null;

        $asset_task->save();

        if (null !== $request->file('asset_task_photo')) {
            $description = 'Photo of '.$asset_task->name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('asset_task_photo'), 'asset_task', $asset_task->id, 'asset_task_photo', $description);
        }

        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('attachment'), 'asset_task', $asset_task->id, 'attachment', $description);
        }

        flash('AssetTask: <a href="'.url('/asset_task/'.$asset_task->id).'">'.$asset_task->name.'</a> updated')->success();

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
        flash('AssetTask: '.$asset_task->name.' deleted')->warning()->important();

        return Redirect::action('AssetTaskController@index');
    }
}
