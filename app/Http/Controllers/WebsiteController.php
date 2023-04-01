<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use Illuminate\Support\Facades\Redirect;

class WebsiteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $this->authorize('show-website');
        $websites = \App\Models\Website::orderBy('url')->whereNotNull('url')->paginate(25, ['*'], 'websites');

        return view('admin.websites.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create-website');

        return view('admin.websites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebsiteRequest $request): RedirectResponse
    {
        $this->authorize('create-website');

        $website = new \App\Models\Website;
        $website->contact_id = $request->input('contact_id');
        $website->url = $request->input('url');
        $website->website_type = $request->input('website_type');
        $website->description = $request->input('description');
        $website->asset_id = $request->input('asset_id');

        $website->save();

        flash('Website: <a href="'.url('/admin/website/'.$website->id).'">'.$website->url.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->authorize('show-website');

        $website = \App\Models\Website::findOrFail($id);

        return view('admin.websites.show', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorize('update-website');

        $website = \App\Models\Website::findOrFail($id);

        return view('admin.websites.edit', compact('website')); //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebsiteRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-website');

        $website = \App\Models\Website::findOrFail($id);

        $website->contact_id = $request->input('contact_id');
        $website->url = $request->input('url');
        $website->website_type = $request->input('website_type');
        $website->description = $request->input('description');
        $website->asset_id = $request->input('asset_id');

        $website->save();

        flash('Website: <a href="'.url('/website/'.$website->id).'">'.$website->url.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $website->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-website');
        $website = \App\Models\Website::findOrFail($id);

        \App\Models\Website::destroy($id);

        flash('Website: '.$website->url.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
