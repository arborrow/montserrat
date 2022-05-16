<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class SsCustomFormController extends Controller
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
        $this->authorize('show-squarespace-custom-form');

        $custom_forms = \App\Models\SsCustomForm::orderBy('name')->with("fields")->get();

        return view('admin.squarespace.custom_forms.index', compact('custom_forms'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-squarespace-custom-form');

        return view('admin.squarespace.custom_forms.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_field($id)
    {
        $this->authorize('create-squarespace-custom-form');
        $custom_form = \App\Models\SsCustomForm::findOrFail($id);

        return view('admin.squarespace.custom_forms.fields.create',compact(['custom_form']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-squarespace-custom-form');

        $custom_form = new \App\Models\SsCustomForm;
        $custom_form->name = $request->input('name');
        $custom_form->save();

        flash('SquareSpace Custom Form: <a href="'.url('admin/squarespace/custom_form/'.$custom_form->id).'">'.$custom_form->name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);

    }


    /**
     * Store a newly created custom form field in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_field(Request $request)
    {
        $this->authorize('create-squarespace-custom-form');
        $id = $request->input('id');
        $custom_form = \App\Models\SsCustomForm::findOrFail($id);
        $custom_form_field = new \App\Models\SsCustomFormField;
        $custom_form_field->form_id = $id;
        $custom_form_field->name = $request->input('name');
        $custom_form_field->type = $request->input('type');
        $custom_form_field->variable_name = $request->input('variable_name');
        $custom_form_field->sort_order = $request->input('sort_order');
        $custom_form_field->save();

        flash('SquareSpace Custom Form: <a href="'.url('admin/squarespace/custom_form/'.$custom_form_field->form_id).'">'.$custom_form_field->name.'</a> field added')->success();

        return Redirect::action([self::class, 'show'],$id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-squarespace-custom-form');

        $custom_form = \App\Models\SsCustomForm::with('fields')->findOrFail($id);

        return view('admin.squarespace.custom_forms.show', compact('custom_form'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-squarespace-custom-form');

        $custom_form = \App\Models\SsCustomForm::with('fields')->findOrFail($id);

        return view('admin.squarespace.custom_forms.edit', compact('custom_form')); //

    }

    /**
     * Show the form for editing custom form field.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_field($id)
    {
        $this->authorize('update-squarespace-custom-form');

        $custom_form_field = \App\Models\SsCustomFormField::with('form')->findOrFail($id);

        return view('admin.squarespace.custom_forms.fields.edit', compact('custom_form_field')); //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update-squarespace-custom-form');

        $custom_form = \App\Models\SsCustomForm::findOrFail($id);

        $custom_form->name = $request->input('name');

        flash('SquareSpace Custom Form: <a href="'.url('admin/squarespace/custom_form/'.$custom_form->id).'">'.$custom_form->name.'</a> updated')->success();
        $custom_form->save();

        return Redirect::action([self::class, 'show'], $custom_form->id);

    }

    /**
     * Update the SquareSpace custom form field in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_field(Request $request)
    {
        $this->authorize('update-squarespace-custom-form');

        $custom_form_field = \App\Models\SsCustomFormField::findOrFail($request->input('id'));

        $custom_form_field->name = $request->input('name');
        $custom_form_field->type = $request->input('type');
        $custom_form_field->variable_name = $request->input('variable_name');
        $custom_form_field->sort_order = $request->input('sort_order');

        flash('SquareSpace Custom Form Field: <a href="'.url('admin/squarespace/custom_form/'.$custom_form_field->form_id).'">'.$custom_form_field->name.' ('. $custom_form_field->form->name . ')</a> updated')->success();
        $custom_form_field->save();

        return Redirect::action([self::class, 'show'], $custom_form_field->form_id);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-squarespace-custom-form');
        $custom_form = \App\Models\SsCustomForm::findOrFail($id);

        \App\Models\SsCustomForm::destroy($id);
        flash('SquareSpace Custom Form: '.$custom_form->name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);

    }
}
