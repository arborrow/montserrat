<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetTypeRequest;
use App\Http\Requests\UpdateAssetTypeRequest;
use Illuminate\Support\Facades\Redirect;

class AssetTypeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-asset-type');
        $asset_types = \App\Models\AssetType::orderBy('label')->get();

        return view('admin.asset_types.index', compact('asset_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-asset-type');
        $asset_types = \App\Models\AssetType::active()->orderBy('label')->pluck('label', 'id');
        $asset_types->prepend('N/A', 0);

        return view('admin.asset_types.create', compact('asset_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetTypeRequest $request)
    {
        $this->authorize('create-asset-type');

        $asset_type = new \App\Models\AssetType;
        $asset_type->label = $request->input('label');
        $asset_type->name = $request->input('name');
        $asset_type->description = $request->input('description');
        $asset_type->is_active = $request->input('is_active');
        $asset_type->parent_asset_type_id = ($request->input('parent_asset_type_id') > 0) ? $request->input('parent_asset_type_id') : null;

        $asset_type->save();

        flash('Asset type: <a href="'.url('/admin/asset_type/'.$asset_type->id).'">'.$asset_type->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-asset-type');

        $asset_type = \App\Models\AssetType::findOrFail($id);

        return view('admin.asset_types.show', compact('asset_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-asset-type');

        $asset_type = \App\Models\AssetType::findOrFail($id);
        $asset_types = \App\Models\AssetType::active()->orderBy('label')->pluck('label', 'id');
        $asset_types->prepend('N/A', 0);

        return view('admin.asset_types.edit', compact('asset_type', 'asset_types')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssetTypeRequest $request, $id)
    {
        $this->authorize('update-asset-type');

        $asset_type = \App\Models\AssetType::findOrFail($request->input('id'));
        $asset_type->name = $request->input('name');
        $asset_type->label = $request->input('label');
        $asset_type->is_active = $request->input('is_active');
        $asset_type->description = $request->input('description');
        $asset_type->parent_asset_type_id = ($request->input('parent_asset_type_id') > 0) ? $request->input('parent_asset_type_id') : null;
        $asset_type->save();

        flash('Asset type: <a href="'.url('/admin/asset_type/'.$asset_type->id).'">'.$asset_type->name.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $asset_type->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-asset-type');
        $asset_type = \App\Models\AssetType::findOrFail($id);

        \App\Models\AssetType::destroy($id);
        flash('Asset type: '.$asset_type->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
