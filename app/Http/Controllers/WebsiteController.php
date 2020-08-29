<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;

class WebsiteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-website');
        $websites = \App\Website::orderBy('url')->whereNotNull('url')->paginate(100);

        return view('admin.websites.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-website');

        return view('admin.websites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWebsiteRequest $request)
    {
        $this->authorize('create-website');

        $website = new \App\Website;
        $website->contact_id = $request->input('contact_id');
        $website->url = $request->input('url');
        $website->website_type = $request->input('website_type');
        $website->description = $request->input('description');
        $website->asset_id = $request->input('asset_id');

        $website->save();

        return Redirect::action('WebsiteController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-website');

        $website = \App\Website::findOrFail($id);

        return view('admin.websites.show', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-website');

        $website = \App\Website::findOrFail($id);

        return view('admin.websites.edit', compact('website')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWebsiteRequest $request, $id)
    {
        $this->authorize('update-website');

        $website = \App\Website::findOrFail($id);

        $website->contact_id = $request->input('contact_id');
        $website->url = $request->input('url');
        $website->website_type = $request->input('website_type');
        $website->description = $request->input('description');
        $website->asset_id = $request->input('asset_id');

        $website->save();

        return Redirect::action('WebsiteController@show',$website->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-website');

        \App\Website::destroy($id);

        return Redirect::action('WebsiteController@index');
    }

}
