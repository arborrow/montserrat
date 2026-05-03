<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSquarespaceCustomFormFieldRequest;
use App\Http\Requests\StoreSquarespaceCustomFormRequest;
use App\Http\Requests\UpdateSquarespaceCustomFormFieldRequest;
use App\Http\Requests\UpdateSquarespaceCustomFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class SquarespaceCustomFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[Authorize('show-squarespace-custom-form')]
    public function index(): View
    {
        $custom_forms = \App\Models\SquarespaceCustomForm::orderBy('name')->with('fields')->get();

        return view('admin.squarespace.custom_forms.index', compact('custom_forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-squarespace-custom-form')]
    public function create(): View
    {
        return view('admin.squarespace.custom_forms.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-squarespace-custom-form')]
    public function create_field($id): View
    {
        $custom_form = \App\Models\SquarespaceCustomForm::findOrFail($id);

        return view('admin.squarespace.custom_forms.fields.create', compact(['custom_form']));
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-squarespace-custom-form')]
    public function store(StoreSquarespaceCustomFormRequest $request): RedirectResponse
    {
        $custom_form = new \App\Models\SquarespaceCustomForm;
        $custom_form->name = $request->input('name');
        $custom_form->save();

        flash('SquareSpace Custom Form: <a href="'.url('admin/squarespace/custom_form/'.$custom_form->id).'">'.$custom_form->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Store a newly created custom form field in storage.
     */
    #[Authorize('create-squarespace-custom-form')]
    public function store_field(StoreSquarespaceCustomFormFieldRequest $request): RedirectResponse
    {
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
    #[Authorize('show-squarespace-custom-form')]
    public function show(int $id): View
    {
        $custom_form = \App\Models\SquarespaceCustomForm::with('fields')->findOrFail($id);

        return view('admin.squarespace.custom_forms.show', compact('custom_form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-squarespace-custom-form')]
    public function edit(int $id): View
    {
        $custom_form = \App\Models\SquarespaceCustomForm::with('fields')->findOrFail($id);

        return view('admin.squarespace.custom_forms.edit', compact('custom_form')); //
    }

    /**
     * Show the form for editing custom form field.
     */
    #[Authorize('update-squarespace-custom-form')]
    public function edit_field(int $id): View
    {
        $custom_form_field = \App\Models\SquarespaceCustomFormField::with('form')->findOrFail($id);

        return view('admin.squarespace.custom_forms.fields.edit', compact('custom_form_field')); //
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-squarespace-custom-form')]
    public function update(UpdateSquarespaceCustomFormRequest $request, int $id): RedirectResponse
    {
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
    #[Authorize('update-squarespace-custom-form')]
    public function update_field(UpdateSquarespaceCustomFormFieldRequest $request): RedirectResponse
    {
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
    #[Authorize('delete-squarespace-custom-form')]
    public function destroy(int $id): RedirectResponse
    {
        $custom_form = \App\Models\SquarespaceCustomForm::findOrFail($id);

        \App\Models\SquarespaceCustomForm::destroy($id);
        flash('SquareSpace Custom Form: '.$custom_form->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
