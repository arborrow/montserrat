<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUomRequest;
use App\Http\Requests\UpdateUomRequest;
use Illuminate\Support\Facades\Redirect;

class UomController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $this->authorize('show-uom');
        $uoms = \App\Models\Uom::orderBy('unit_name')->get();

        return view('admin.uoms.index', compact('uoms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create-uom');
        $uom_types = config('polanco.uom_types');

        return view('admin.uoms.create', compact('uom_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUomRequest $request): RedirectResponse
    {
        $this->authorize('create-uom');

        $uom = new \App\Models\Uom;
        $uom->type = $request->input('type');
        $uom->unit_name = $request->input('unit_name');
        $uom->unit_symbol = $request->input('unit_symbol');
        $uom->description = $request->input('description');
        $uom->is_active = $request->input('is_active');

        $uom->save();

        flash('Unit of measure: <a href="'.url('/admin/uom/'.$uom->id).'">'.$uom->unit_name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->authorize('show-uom');

        $uom = \App\Models\Uom::findOrFail($id);

        return view('admin.uoms.show', compact('uom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorize('update-uom');

        $uom = \App\Models\Uom::findOrFail($id);
        $uom_types = config('polanco.uom_types');

        return view('admin.uoms.edit', compact('uom', 'uom_types')); //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUomRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-uom');

        $uom = \App\Models\Uom::findOrFail($id);

        $uom->type = $request->input('type');
        $uom->unit_name = $request->input('unit_name');
        $uom->unit_symbol = $request->input('unit_symbol');
        $uom->description = $request->input('description');
        $uom->is_active = $request->input('is_active');

        $uom->save();

        flash('Unit of measure: <a href="'.url('/admin/uom/'.$uom->id).'">'.$uom->unit_name.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $uom->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-uom');
        $uom = \App\Models\Uom::findOrFail($id);

        \App\Models\Uom::destroy($id);

        flash('Unit of measure: '.$uom->unit_name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
