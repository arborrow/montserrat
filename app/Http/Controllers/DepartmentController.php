<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $this->authorize('show-department');

        $departments = \App\Models\Department::orderBy('name')->get();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create-department');

        $parents = \App\Models\Department::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        return view('admin.departments.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        $this->authorize('create-department');

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
    public function show(int $id): View
    {
        $this->authorize('show-department');

        $department = \App\Models\Department::findOrFail($id);
        $children = \App\Models\Department::whereParentId($id)->get();

        return view('admin.departments.show', compact('department', 'children'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorize('update-department');

        $department = \App\Models\Department::findOrFail($id);

        $parents = \App\Models\Department::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        return view('admin.departments.edit', compact('department', 'parents')); //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-department');

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
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-department');
        $department = \App\Models\Department::findOrFail($id);

        \App\Models\Department::destroy($id);
        flash('Department: '.$department->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
