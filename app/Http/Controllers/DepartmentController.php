<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class DepartmentController extends Controller
{
    #[Authorize('show-department')]
    public function index(): View
    {
        $departments = \App\Models\Department::orderBy('name')->get();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-department')]
    public function create(): View
    {
        $parents = \App\Models\Department::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        return view('admin.departments.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-department')]
    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        $department = new \App\Models\Department;
        $department->name = $request->input('name');
        $department->label = $request->input('label');
        $department->description = $request->input('description');
        $department->notes = $request->input('notes');
        $department->parent_id = $request->input('parent_id');
        $department->is_active = $request->input('is_active');

        $department->save();

        flash('Department: <a href="'.url('/admin/department/'.$department->id).'">'.$department->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('show-department')]
    public function show(int $id): View
    {
        $department = \App\Models\Department::findOrFail($id);
        $children = \App\Models\Department::whereParentId($id)->get();

        return view('admin.departments.show', compact('department', 'children'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-department')]
    public function edit(int $id): View
    {
        $department = \App\Models\Department::findOrFail($id);

        $parents = \App\Models\Department::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        return view('admin.departments.edit', compact('department', 'parents')); //
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-department')]
    public function update(UpdateDepartmentRequest $request, int $id): RedirectResponse
    {
        $department = \App\Models\Department::findOrFail($id);

        $department->name = $request->input('name');
        $department->label = $request->input('label');
        $department->description = $request->input('description');
        $department->notes = $request->input('notes');
        $department->parent_id = $request->input('parent_id');
        $department->is_active = $request->input('is_active');

        flash('Department: <a href="'.url('/admin/department/'.$department->id).'">'.$department->name.'</a> updated')->success();
        $department->save();

        return Redirect::action([self::class, 'show'], $department->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete-department')]
    public function destroy(int $id): RedirectResponse
    {
        $department = \App\Models\Department::findOrFail($id);

        \App\Models\Department::destroy($id);
        flash('Department: '.$department->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
