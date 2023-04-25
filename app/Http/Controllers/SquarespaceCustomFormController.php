<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSquarespaceCustomFormFieldRequest;
use App\Http\Requests\StoreSquarespaceCustomFormRequest;
use App\Http\Requests\UpdateSquarespaceCustomFormFieldRequest;
use App\Http\Requests\UpdateSquarespaceCustomFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SquarespaceCustomFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('show-squarespace-custom-form');

        $custom_forms = \App\Models\SquarespaceCustomForm::orderBy('name')->with('fields')->get();

        return view('admin.squarespace.custom_forms.index', compact('custom_forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create-squarespace-custom-form');

        return view('admin.squarespace.custom_forms.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_field($id): View
    {
        $this->authorize('create-squarespace-custom-form');
        $custom_form = \App\Models\SquarespaceCustomForm::findOrFail($id);

        return view('admin.squarespace.custom_forms.fields.create', compact(['custom_form']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSquarespaceCustomFormRequest $request): RedirectResponse
    {
        $this->authorize('create-squarespace-custom-form');

        $custom_form = new \App\Models\SquarespaceCustomForm;
        $custom_form->name = $request->input('name');
        $custom_form->save();

        flash('SquareSpace Custom Form: <a href="'.url('admin/squarespace/custom_form/'.$custom_form->id).'">'.$custom_form->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Store a newly created custom form field in storage.
     */
    public function store_field(StoreSquarespaceCustomFormFieldRequest $request): RedirectResponse
    {
        $this->authorize('create-squarespace-custom-form');
        $id = $request->input('id');
        $custom_form = \App\Models\SquarespaceCustomForm::findOrFail($id);
        $custom_form_field = new \App\Models\SquarespaceCustomFormField;
        $custom_form_field->form_id = $id;
        $custom_form_field->name = $request->input('name');
        $custom_form_field->type = $request->input('type');
        $custom_form_field->variable_name = $request->input('variable_name');
        $custom_form_field->sort_order = $request->input('sort_order');
        $custom_form_field->save();

        flash('SquareSpace Custom Form: <a href="'.url('admin/squarespace/custom_form/'.$custom_form_field->form_id).'">'.$custom_form_field->name.'</a> field added')->success();

        return Redirect::action([self::class, 'show'], $id);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->authorize('show-squarespace-custom-form');

        $custom_form = \App\Models\SquarespaceCustomForm::with('fields')->findOrFail($id);

        return view('admin.squarespace.custom_forms.show', compact('custom_form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorize('update-squarespace-custom-form');

        $custom_form = \App\Models\SquarespaceCustomForm::with('fields')->findOrFail($id);

        return view('admin.squarespace.custom_forms.edit', compact('custom_form')); //
    }

    /**
     * Show the form for editing custom form field.
     */
    public function edit_field(int $id): View
    {
        $this->authorize('update-squarespace-custom-form');

        $custom_form_field = \App\Models\SquarespaceCustomFormField::with('form')->findOrFail($id);

        return view('admin.squarespace.custom_forms.fields.edit', compact('custom_form_field')); //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSquarespaceCustomFormRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-squarespace-custom-form');

        $custom_form = \App\Models\SquarespaceCustomForm::findOrFail($id);

        $custom_form->name = $request->input('name');

        flash('SquareSpace Custom Form: <a href="'.url('admin/squarespace/custom_form/'.$custom_form->id).'">'.$custom_form->name.'</a> updated')->success();
        $custom_form->save();

        return Redirect::action([self::class, 'show'], $custom_form->id);
    }

    /**
     * Update the SquareSpace custom form field in storage.
     *
     * @param  int  $id
     */
    public function update_field(UpdateSquarespaceCustomFormFieldRequest $request): RedirectResponse
    {
        $this->authorize('update-squarespace-custom-form');

        $custom_form_field = \App\Models\SquarespaceCustomFormField::findOrFail($request->input('id'));

        $custom_form_field->name = $request->input('name');
        $custom_form_field->type = $request->input('type');
        $custom_form_field->variable_name = $request->input('variable_name');
        $custom_form_field->sort_order = $request->input('sort_order');
        $custom_form_field->save();

        flash('SquareSpace Custom Form Field: <a href="'.url('admin/squarespace/custom_form/'.$custom_form_field->form_id).'">'.$custom_form_field->name.' ('.$custom_form_field->form->name.')</a> updated')->success();

        return Redirect::action([self::class, 'show'], $custom_form_field->form_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-squarespace-custom-form');
        $custom_form = \App\Models\SquarespaceCustomForm::findOrFail($id);

        \App\Models\SquarespaceCustomForm::destroy($id);
        flash('SquareSpace Custom Form: '.$custom_form->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
