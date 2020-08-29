<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-department');

        $departments = \App\Department::orderBy('name')->get();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-department');

        $parents = \App\Department::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        return view('admin.departments.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        $this->authorize('create-department');

        $department = new \App\Department;
        $department->name = $request->input('name');
        $department->label = $request->input('label');
        $department->description = $request->input('description');
        $department->notes = $request->input('notes');
        $department->parent_id = $request->input('parent_id');
        $department->is_active = $request->input('is_active');

        $department->save();

        return Redirect::action('DepartmentController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-department');

        $department = \App\Department::findOrFail($id);
        $children = \App\Department::whereParentId($id)->get();

        return view('admin.departments.show', compact('department', 'children'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-department');

        $department = \App\Department::findOrFail($id);

        $parents = \App\Department::orderBy('name')->pluck('name', 'id');
        $parents->prepend('N/A', 0);

        return view('admin.departments.edit', compact('department', 'parents')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, $id)
    {
        $this->authorize('update-department');

        $department = \App\Department::findOrFail($id);

        $department->name = $request->input('name');
        $department->label = $request->input('label');
        $department->description = $request->input('description');
        $department->notes = $request->input('notes');
        $department->parent_id = $request->input('parent_id');
        $department->is_active = $request->input('is_active');

        $department->save();

        return Redirect::action('DepartmentController@show', $department->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-department');

        \App\Department::destroy($id);

        return Redirect::action('DepartmentController@index');
    }
}
