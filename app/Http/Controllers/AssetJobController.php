<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Http\Requests\AssetSearchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-asset');

        $asset_types = \App\Models\AssetType::active()->orderBy('label')->pluck('label', 'id');
        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');

        $assets = \App\Models\Asset::orderBy('name')->get();

        return view('assets.index', compact('assets', 'asset_types', 'locations'));
    }

    public function index_type($type = null)
    {
        $this->authorize('show-asset');

        $asset_types = \App\Models\AssetType::active()->orderBy('label')->pluck('label', 'id');
        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');

        $assets = \App\Models\Asset::whereAssetTypeId($type)->orderBy('name')->get();

        return view('assets.index', compact('assets', 'asset_types', 'locations'));
    }

    public function index_location($location_id = null)
    {
        $this->authorize('show-asset');

        $asset_types = \App\Models\AssetType::active()->orderBy('label')->pluck('label', 'id');
        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');

        $assets = \App\Models\Asset::whereLocationId($location_id)->orderBy('name')->get();

        return view('assets.index', compact('assets', 'asset_types', 'locations'));
    }

    public function search()
    {
        $this->authorize('show-asset');

        $asset_types = \App\Models\AssetType::active()->orderBy('label')->pluck('label', 'id');
        $asset_types->prepend('N/A', '');

        $departments = \App\Models\Department::active()->orderBy('label')->pluck('label', 'id');
        $departments->prepend('N/A', '');

        // TODO: determine and set up various depreciation types
        $depreciation_types = [''=>'N/A'];

        $locations = \App\Models\Location::orderBy('name')->pluck('name', 'id');
        $locations->prepend('N/A', '');

        $parents = \App\Models\Asset::active()->orderBy('name')->pluck('name', 'id');
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

        return view('assets.search', compact('asset_types', 'departments', 'depreciation_types', 'locations', 'parents', 'uoms_capacity', 'uoms_electric', 'uoms_length', 'uoms_time', 'uoms_weight', 'vendors'));
    }

    public function results(AssetSearchRequest $request)
    {
        $this->authorize('show-asset');
        if (! empty($request)) {
            $assets = \App\Models\Asset::filtered($request)->orderBy('name')->paginate(100);
            $assets->appends($request->except('page'));
        } else {
            $assets = \App\Models\Asset::orderBy('name')->paginate(100);
        }

        return view('assets.results', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-asset');

        $asset_types = \App\Models\AssetType::active()->orderBy('label')->pluck('label', 'id');
        $asset_types->prepend('N/A', '');

        $departments = \App\Models\Department::active()->orderBy('label')->pluck('label', 'id');
        $departments->prepend('N/A', '');

        $parents = \App\Models\Asset::active()->orderBy('name')->pluck('name', 'id');
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

        return view('assets.create', compact('asset_types', 'departments', 'parents', 'locations', 'vendors', 'uoms_electric', 'uoms_length', 'uoms_weight', 'uoms_capacity', 'uoms_time', 'depreciation_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetRequest $request)
    {
        $this->authorize('create-asset');

        $asset = new \App\Models\Asset;
        //General info
        $asset->name = $request->input('name');
        $asset->asset_type_id = $request->input('asset_type_id');
        $asset->description = $request->input('description');

        $asset->manufacturer = $request->input('manufacturer');
        $asset->model = $request->input('model');
        $asset->serial_number = $request->input('serial_number');
        $asset->year = $request->input('year');

        $asset->location_id = ($request->input('location_id') > 0) ? $request->input('location_id') : null;
        $asset->department_id = ($request->input('department_id') > 0) ? $request->input('department_id') : null;
        $asset->parent_id = ($request->input('parent_id') > 0) ? $request->input('parent_id') : null;
        $asset->status = $request->input('status');
        $asset->remarks = $request->input('remarks');
        $asset->is_active = $request->input('is_active');

        //Service information
        $asset->manufacturer_id = ($request->input('manufacturer_id') > 0) ? $request->input('manufacturer_id') : null;
        $asset->vendor_id = ($request->input('vendor_id') > 0) ? $request->input('vendor_id') : null;

        //Power specs
        $asset->power_line_voltage = $request->input('power_line_voltage');
        $asset->power_line_voltage_uom_id = ($request->input('power_line_voltage_uom_id') > 0) ? $request->input('power_line_voltage_uom_id') : null;
        $asset->power_phase_voltage = $request->input('power_phase_voltage');
        $asset->power_phase_voltage_uom_id = ($request->input('power_phase_voltage_uom_id') > 0) ? $request->input('power_phase_voltage_uom_id') : null;
        $asset->power_phases = $request->input('power_phases');
        $asset->power_amp = $request->input('power_amp');
        $asset->power_amp_uom_id = ($request->input('power_amp_uom_id') > 0) ? $request->input('power_amp_uom_id') : null;

        //Physical specs
        $asset->length = $request->input('length');
        $asset->length_uom_id = ($request->input('length_uom_id') > 0) ? $request->input('length_uom_id') : null;
        $asset->width = $request->input('width');
        $asset->width_uom_id = ($request->input('width_uom_id') > 0) ? $request->input('width_uom_id') : null;
        $asset->height = $request->input('height');
        $asset->height_uom_id = ($request->input('height_uom_id') > 0) ? $request->input('height_uom_id') : null;
        $asset->weight = $request->input('weight');
        $asset->weight_uom_id = ($request->input('weight_uom_id') > 0) ? $request->input('weight_uom_id') : null;
        $asset->capacity = $request->input('capacity');
        $asset->capacity_uom_id = ($request->input('capacity_uom_id') > 0) ? $request->input('capacity_uom_id') : null;

        //Purchase info
        $asset->purchase_date = $request->input('purchase_date');
        $asset->purchase_price = $request->input('purchase_price');
        $asset->life_expectancy = $request->input('life_expectancy');
        $asset->life_expectancy_uom_id = ($request->input('life_expectancy_uom_id') > 0) ? $request->input('life_expectancy_uom_id') : null;
        $asset->start_date = $request->input('start_date');
        $asset->end_date = $request->input('end_date');
        $asset->replacement_id = ($request->input('replacement_id') > 0) ? $request->input('replacement_id') : null;

        //Warranty info
        $asset->warranty_start_date = $request->input('warranty_start_date');
        $asset->warranty_end_date = $request->input('warranty_end_date');

        //Depreciation info
        $asset->depreciation_start_date = $request->input('depreciation_start_date');
        $asset->depreciation_end_date = $request->input('depreciation_end_date');
        $asset->depreciation_type_id = ($request->input('depreciation_type_id') > 0) ? $request->input('depreciation_type_id') : null;
        $asset->depreciation_rate = $request->input('depreciation_rate');
        $asset->depreciation_value = $request->input('depreciation_value');
        $asset->depreciation_time = $request->input('depreciation_time');
        $asset->depreciation_time_uom_id = ($request->input('depreciation_time_uom_id') > 0) ? $request->input('depreciation_time_uom_id') : null;

        $asset->save();

        if (null !== $request->file('asset_photo')) {
            $description = 'Photo of '.$asset->name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('asset_photo'), 'asset', $asset->id, 'asset_photo', $description);
        }

        flash('Asset: <a href="'.url('/asset/'.$asset->id).'">'.$asset->name.'</a> added')->success();

        return Redirect::action('AssetController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-asset');

        $asset = \App\Models\Asset::findOrFail($id);
        $files = \App\Models\Attachment::whereEntity('asset')->whereEntityId($asset->id)->whereFileTypeId(config('polanco.file_type.asset_attachment'))->get();

        return view('assets.show', compact('asset', 'files'));
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

        $asset = \App\Models\Asset::findOrFail($id);

        $asset_types = \App\Models\AssetType::active()->orderBy('label')->pluck('label', 'id');
        $asset_types->prepend('N/A', '');

        $departments = \App\Models\Department::active()->orderBy('label')->pluck('label', 'id');
        $departments->prepend('N/A', '');

        $parents = \App\Models\Asset::active()->orderBy('name')->pluck('name', 'id');
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

        return view('assets.edit', compact('asset', 'asset_types', 'departments', 'parents', 'locations', 'vendors', 'uoms_electric', 'uoms_length', 'uoms_weight', 'uoms_time', 'uoms_capacity', 'depreciation_types')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssetRequest $request, $id)
    {
        $this->authorize('update-asset');

        $asset = \App\Models\Asset::findOrFail($id);

        //General info
        $asset->name = $request->input('name');
        $asset->asset_type_id = $request->input('asset_type_id');
        $asset->description = $request->input('description');

        $asset->manufacturer = $request->input('manufacturer');
        $asset->model = $request->input('model');
        $asset->serial_number = $request->input('serial_number');
        $asset->year = $request->input('year');

        $asset->location_id = ($request->input('location_id') > 0) ? $request->input('location_id') : null;
        $asset->department_id = ($request->input('department_id') > 0) ? $request->input('department_id') : null;
        $asset->parent_id = ($request->input('parent_id') > 0) ? $request->input('parent_id') : null;
        $asset->status = $request->input('status');
        $asset->remarks = $request->input('remarks');
        $asset->is_active = $request->input('is_active');

        //Service information
        $asset->manufacturer_id = ($request->input('manufacturer_id') > 0) ? $request->input('manufacturer_id') : null;
        $asset->vendor_id = ($request->input('vendor_id') > 0) ? $request->input('vendor_id') : null;

        //Power specs
        $asset->power_line_voltage = $request->input('power_line_voltage');
        $asset->power_line_voltage_uom_id = ($request->input('power_line_voltage_uom_id') > 0) ? $request->input('power_line_voltage_uom_id') : null;
        $asset->power_phase_voltage = $request->input('power_phase_voltage');
        $asset->power_phase_voltage_uom_id = ($request->input('power_phase_voltage_uom_id') > 0) ? $request->input('power_phase_voltage_uom_id') : null;
        $asset->power_phases = $request->input('power_phases');
        $asset->power_amp = $request->input('power_amp');
        $asset->power_amp_uom_id = ($request->input('power_amp_uom_id') > 0) ? $request->input('power_amp_uom_id') : null;

        //Physical specs
        $asset->length = $request->input('length');
        $asset->length_uom_id = ($request->input('length_uom_id') > 0) ? $request->input('length_uom_id') : null;
        $asset->width = $request->input('width');
        $asset->width_uom_id = ($request->input('width_uom_id') > 0) ? $request->input('width_uom_id') : null;
        $asset->height = $request->input('height');
        $asset->height_uom_id = ($request->input('height_uom_id') > 0) ? $request->input('height_uom_id') : null;
        $asset->weight = $request->input('weight');
        $asset->weight_uom_id = ($request->input('weight_uom_id') > 0) ? $request->input('weight_uom_id') : null;
        $asset->capacity = $request->input('capacity');
        $asset->capacity_uom_id = ($request->input('capacity_uom_id') > 0) ? $request->input('capacity_uom_id') : null;

        //Purchase info
        $asset->purchase_date = $request->input('purchase_date');
        $asset->purchase_price = $request->input('purchase_price');
        $asset->life_expectancy = $request->input('life_expectancy');
        $asset->life_expectancy_uom_id = ($request->input('life_expectancy_uom_id') > 0) ? $request->input('life_expectancy_uom_id') : null;
        $asset->start_date = $request->input('start_date');
        $asset->end_date = $request->input('end_date');
        $asset->replacement_id = ($request->input('replacement_id') > 0) ? $request->input('replacement_id') : null;

        //Warranty info
        $asset->warranty_start_date = $request->input('warranty_start_date');
        $asset->warranty_end_date = $request->input('warranty_end_date');

        //Depreciation info
        $asset->depreciation_start_date = $request->input('depreciation_start_date');
        $asset->depreciation_end_date = $request->input('depreciation_end_date');
        $asset->depreciation_type_id = ($request->input('depreciation_type_id') > 0) ? $request->input('depreciation_type_id') : null;
        $asset->depreciation_rate = $request->input('depreciation_rate');
        $asset->depreciation_value = $request->input('depreciation_value');
        $asset->depreciation_time = $request->input('depreciation_time');
        $asset->depreciation_time_uom_id = ($request->input('depreciation_time_uom_id') > 0) ? $request->input('depreciation_time_uom_id') : null;

        $asset->save();

        if (null !== $request->file('asset_photo')) {
            $description = 'Photo of '.$asset->name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('asset_photo'), 'asset', $asset->id, 'asset_photo', $description);
        }

        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('attachment'), 'asset', $asset->id, 'attachment', $description);
        }

        flash('Asset: <a href="'.url('/asset/'.$asset->id).'">'.$asset->name.'</a> updated')->success();

        return Redirect::action('AssetController@show', $asset->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-asset');
        $asset = \App\Models\Asset::findOrFail($id);

        \App\Models\Asset::destroy($id);
        flash('Asset: '.$asset->name.' deleted')->warning()->important();

        return Redirect::action('AssetController@index');
    }
}
