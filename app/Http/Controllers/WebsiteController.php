<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

#[Middleware('auth')]
class WebsiteController extends Controller
{
    #[Authorize('show-website')]
    public function index(): View
    {
        $websites = \App\Models\Website::orderBy('url')->whereNotNull('url')->paginate(25, ['*'], 'websites');

        return view('admin.websites.index', compact('websites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-website')]
    public function create(): View
    {
        return view('admin.websites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-website')]
    public function store(StoreWebsiteRequest $request): RedirectResponse
    {
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
    #[Authorize('show-website')]
    public function show(int $id): View
    {
        $website = \App\Models\Website::findOrFail($id);

        return view('admin.websites.show', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-website')]
    public function edit(int $id): View
    {
        $website = \App\Models\Website::findOrFail($id);

        return view('admin.websites.edit', compact('website')); //
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update-website')]
    public function update(UpdateWebsiteRequest $request, int $id): RedirectResponse
    {
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
    #[Authorize('delete-website')]
    public function destroy(int $id): RedirectResponse
    {
        $website = \App\Models\Website::findOrFail($id);

        \App\Models\Website::destroy($id);

        flash('Website: '.$website->url.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}
