<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSquarespaceInventoryRequest;
use App\Http\Requests\UpdateSquarespaceInventoryRequest;
use Illuminate\Support\Facades\Redirect;

class SquarespaceInventoryController extends Controller
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
        $this->authorize('show-squarespace-inventory');

        $inventory_items = \App\Models\SquarespaceInventory::orderBy('name')->with('custom_form')->get();

        return view('admin.squarespace.inventory.index', compact('inventory_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-squarespace-inventory');
        $custom_forms = \App\Models\SquarespaceCustomForm::orderBy('name')->pluck('name', 'id');

        return view('admin.squarespace.inventory.create', compact(['custom_forms']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSquarespaceInventoryRequest $request)
    {
        $this->authorize('create-squarespace-inventory');

        $inventory = new \App\Models\SquarespaceInventory;
        $inventory->name = $request->input('name');
        $inventory->custom_form_id = $request->input('custom_form_id');
        $inventory->variant_options = $request->input('variant_options');
        $inventory->save();

        flash('SquareSpace Inventory: <a href="'.url('/squarespace/inventory/'.$inventory->id).'">'.$inventory->name.'</a> added')->success();

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
        $this->authorize('show-squarespace-inventory');

        $inventory = \App\Models\SquarespaceInventory::with('custom_form')->findOrFail($id);

        return view('admin.squarespace.inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-squarespace-inventory');

        $inventory = \App\Models\SquarespaceInventory::findOrFail($id);
        $custom_forms = \App\Models\SquarespaceCustomForm::orderBy('name')->pluck('name', 'id');

        return view('admin.squarespace.inventory.edit', compact('inventory', 'custom_forms')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSquarespaceInventoryRequest $request, $id)
    {
        $this->authorize('update-squarespace-inventory');

        $inventory = \App\Models\SquarespaceInventory::findOrFail($id);

        $inventory->name = $request->input('name');
        $inventory->custom_form_id = $request->input('custom_form_id');
        $inventory->variant_options = $request->input('variant_options');

        flash('SquareSpace Inventory: <a href="'.url('admin/squarespace/custom_form/'.$inventory->id).'">'.$inventory->name.'</a> updated')->success();
        $inventory->save();

        return Redirect::action([self::class, 'show'], $inventory->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-squarespace-inventory');
        $inventory = \App\Models\SquarespaceInventory::findOrFail($id);

        \App\Models\SquarespaceInventory::destroy($id);
        flash('SquareSpace Inventory: '.$inventory->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
