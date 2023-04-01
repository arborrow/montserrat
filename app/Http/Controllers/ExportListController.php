<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreExportListRequest;
use App\Http\Requests\UpdateExportListRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ExportListController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $this->authorize('show-export-list');
        $export_lists = \App\Models\ExportList::orderBy('label')->get();

        return view('admin.export_lists.index', compact('export_lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create-export-list');
        $export_list_types = config('polanco.export_list_types');

        return view('admin.export_lists.create', compact('export_list_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExportListRequest $request): RedirectResponse
    {
        $this->authorize('create-export-list');

        $export_list = new \App\Models\ExportList;
        $export_list->title = $request->input('title');
        $export_list->label = $request->input('label');
        $export_list->type = $request->input('type');
        $export_list->fields = $request->input('fields');
        $export_list->filters = $request->input('filters');
        $export_list->start_date = $request->input('start_date');
        $export_list->end_date = $request->input('end_date');
        $export_list->last_run_date = $request->input('last_run_date');
        $export_list->next_scheduled_date = $request->input('next_scheduled_date');

        $export_list->save();

        flash('Export list: <a href="'.url('/admin/export_list/'.$export_list->id).'">'.$export_list->label.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->authorize('show-export-list');

        $export_list = \App\Models\ExportList::findOrFail($id);

        return view('admin.export_lists.show', compact('export_list'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorize('update-export-list');

        $export_list = \App\Models\ExportList::findOrFail($id);
        $export_list_types = config('polanco.export_list_types');

        return view('admin.export_lists.edit', compact('export_list', 'export_list_types')); //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExportListRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-export-list');

        $export_list = \App\Models\ExportList::findOrFail($id);

        $export_list->title = $request->input('title');
        $export_list->label = $request->input('label');
        $export_list->type = $request->input('type');
        $export_list->fields = $request->input('fields');
        $export_list->filters = $request->input('filters');
        $export_list->start_date = $request->input('start_date');
        $export_list->end_date = $request->input('end_date');
        $export_list->last_run_date = $request->input('last_run_date');
        $export_list->next_scheduled_date = $request->input('next_scheduled_date');

        $export_list->save();

        flash('Export list: <a href="'.url('/admin/export_list/'.$export_list->id).'">'.$export_list->label.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $export_list->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-export-list');
        $export_list = \App\Models\ExportList::findOrFail($id);

        \App\Models\ExportList::destroy($id);

        flash('Export list: '.$export_list->label.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Setup and export to CSV the Annual Giving Campaign (AGC) export/mailing list.
     *
     * @param  ExportListAGCRequest  $request
     */
//    public function agc(ExportListAGCRequest $request)
    public function agc(): RedirectResponse
    {
        $this->authorize('show-export-list');
        // $id = $request->input('id');
        // $export_list = \App\Models\ExportList::findOrFail($id);
        // $start_date = $request->input('start_date');
        // $end_date = $request->input('end_date');
        $start_date = new Carbon('2016-01-01 00:00:00');
        $end_date = Carbon::now();
        // dd($start_date,$end_date);

        /* get by collection
                $participants = \App\Registration::with('event','contact.address_primary','contact.prefix','contact.suffix')
                ->whereNull('canceled_at')
                ->whereHas('event', function($q) use ($start_date){
                    $q->where('start_date', '>=', $start_date);
                })
                ->whereHas('event', function($q) use ($end_date){
                    $q->where('start_date', '<', $end_date);
                })
                ->whereHas('contact', function($q) {
                        $q->whereContactType(1)
                        ->whereDoNotMail(0)
                        ->whereIsDeceased(0);
                })
                ->whereHas('contact.address_primary', function($q) {
                        $q->with('state','country')
                        ->whereIsPrimary(1)
                        ->whereNotNull('street_address');
                })
                ->groupBy('contact_id')
                ->get();

                $donors = \App\Donation::with('payments','contact.address_primary.state','contact.address_primary.country','contact.prefix','contact.suffix')
                ->where('donation_amount','>',0)
                ->whereHas('payments', function($q) use ($start_date, $end_date){
                    $q->where('payment_date', '>=', $start_date)
                    ->where('payment_date', '<', $end_date);
                })
                ->whereHas('contact', function($q) {
                        $q->whereContactType(1)
                        ->whereDoNotMail(0)
                        ->whereIsDeceased(0);
                })
                ->whereHas('contact.address_primary', function($q) {
                        $q->with('state','country')
                        ->whereIsPrimary(1)
                        ->whereNotNull('street_address');
                })
                ->groupBy('contact_id')
                ->get();

                */

        $participants = DB::table('participant')
        ->distinct()
        ->select('participant.contact_id', 'prefix.name', 'contact.first_name', 'contact.last_name', 'contact.sort_name', 'contact.display_name', 'address.street_address', 'address.supplemental_address_1', 'address.city', 'state_province.abbreviation', 'address.postal_code')
        ->leftJoin('contact', 'participant.contact_id', '=', 'contact.id')
        ->leftJoin('prefix', 'prefix.id', '=', 'contact.prefix_id')
        ->leftJoin('event', 'event.id', '=', 'participant.event_id')
        ->leftJoin('address', 'address.contact_id', '=', 'participant.contact_id')
        ->leftJoin('state_province', 'state_province.id', '=', 'address.state_province_id')
        ->whereNull('participant.canceled_at')
        ->whereNull('participant.deleted_at')
        ->whereNull('address.deleted_at')
        ->where('event.start_date', '>=', $start_date)
        ->where('event.start_date', '<', $end_date)
        ->where('contact.do_not_mail', '=', 0)
        ->where('contact.is_deceased', '=', 0)
        ->where('contact.contact_type', '=', 1)
        ->where('address.is_primary', '=', 1)
        ->whereNull('address.deleted_at')
        ->whereNotNull('address.street_address')
        ->orderBy('contact.sort_name')->get();
        dd($participants->get());

        return Redirect::action([self::class, 'index']);
    }
}
