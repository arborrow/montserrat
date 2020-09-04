<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;

use App\Http\Requests\StoreSnippetRequest;
use App\Http\Requests\UpdateSnippetRequest;

class SnippetController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-snippet');

        $titles = \App\Snippet::groupBy('label')->orderBy('label')->pluck('title', 'title');
        $snippets = \App\Snippet::orderBy('title')->orderBy('locale')->orderBy('label')->get();

        return view('admin.snippets.index', compact('snippets','titles'));
    }

    public function index_type($title = null)
    {
        $this->authorize('show-snippet');

        $titles = \App\Snippet::groupBy('label')->orderBy('label')->pluck('title', 'title');
        $snippets = \App\Snippet::whereTitle($title)->orderBy('title')->orderBy('locale')->orderBy('label')->get();

        return view('admin.snippets.index', compact('snippets', 'titles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-snippet');
        $locales = \App\Language::whereIsActive(1)->orderBy('label')->pluck('label','name');

        return view('admin.snippets.create',compact('locales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSnippetRequest $request)
    {
        $this->authorize('create-snippet');

        $snippet = new \App\Snippet;
        $snippet->title = $request->input('title');
        $snippet->label = $request->input('label');
        $snippet->locale = $request->input('locale');
        $snippet->snippet = $request->input('snippet');

        $snippet->save();

        return Redirect::action('SnippetController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-snippet');

        $snippet = \App\Snippet::findOrFail($id);

        return view('admin.snippets.show', compact('snippet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-snippet');

        $snippet = \App\Snippet::findOrFail($id);
        $locales = \App\Language::whereIsActive(1)->orderBy('label')->pluck('label','name');

        return view('admin.snippets.edit', compact('snippet', 'locales')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSnippetRequest $request, $id)
    {
        $this->authorize('update-snippet');

        $snippet = \App\Snippet::findOrFail($id);

        $snippet->title = $request->input('title');
        $snippet->label = $request->input('label');
        $snippet->locale = $request->input('locale');
        $snippet->snippet = $request->input('snippet');

        $snippet->save();

        return Redirect::action('SnippetController@show', $snippet->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-snippet');

        \App\Snippet::destroy($id);

        return Redirect::action('SnippetController@index');
    }
}
