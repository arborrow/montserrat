<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreAssetTypeRequest;
use App\Http\Requests\UpdateAssetTypeRequest;

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
        $asset_types = \App\AssetType::orderBy('label')->get();

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
        $asset_types = \App\AssetType::active()->orderBy('label')->pluck('label','id');
        $asset_types->prepend('N/A',0);

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

        $asset_type = new \App\AssetType;
        $asset_type->label = $request->input('label');
        $asset_type->name = $request->input('name');
        $asset_type->description = $request->input('description');
        $asset_type->is_active = $request->input('is_active');
        $asset_type->parent_asset_type_id = ($request->input('parent_asset_type_id') > 0) ? $request->input('parent_asset_type_id') : null;

        $asset_type->save();

        return Redirect::action('AssetTypeController@index');
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

        $asset_type = \App\AssetType::findOrFail($id);

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

        $asset_type = \App\AssetType::findOrFail($id);
        $asset_types = \App\AssetType::active()->orderBy('label')->pluck('label','id');
        $asset_types->prepend('N/A',0);

        return view('admin.asset_types.edit', compact('asset_type','asset_types')); //
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

        $asset_type = \App\AssetType::findOrFail($request->input('id'));
        $asset_type->name = $request->input('name');
        $asset_type->label = $request->input('label');
        $asset_type->is_active = $request->input('is_active');
        $asset_type->description = $request->input('description');
        $asset_type->parent_asset_type_id = ($request->input('parent_asset_type_id') > 0) ? $request->input('parent_asset_type_id') : null;
        $asset_type->save();

        return Redirect::action('AssetTypeController@show',$asset_type->id);
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

        \App\AssetType::destroy($id);

        return Redirect::action('AssetTypeController@index');
    }

}