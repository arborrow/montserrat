<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUomRequest;
use App\Http\Requests\UpdateUomRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class UomController extends Controller
{
    #[Authorize('show-uom')]
    public function index(): View
    {
        $uoms = \App\Models\Uom::orderBy('unit_name')->get();

        return view('admin.uoms.index', compact('uoms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-uom')]
    public function create(): View
    {
        $uom_types = config('polanco.uom_types');

        return view('admin.uoms.create', compact('uom_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-uom')]
    public function store(StoreUomRequest $request): RedirectResponse
    {
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
    #[Authorize('show-uom')]
    public function show(int $id): View
    {
        $uom = \App\Models\Uom::findOrFail($id);

        return view('admin.uoms.show', compact('uom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-uom')]
    public function edit(int $id): View
    {
        $uom = \App\Models\Uom::findOrFail($id);
        $uom_types = config('polanco.uom_types');

        return view('admin.uoms.edit', compact('uom', 'uom_types')); //
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-uom')]
    public function update(UpdateUomRequest $request, int $id): RedirectResponse
    {
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
    #[Authorize('delete-uom')]
    public function destroy(int $id): RedirectResponse
    {
        $uom = \App\Models\Uom::findOrFail($id);

        \App\Models\Uom::destroy($id);

        flash('Unit of measure: '.$uom->unit_name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
