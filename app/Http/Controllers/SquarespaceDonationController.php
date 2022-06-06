<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateSsDonationRequest;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Donation;
use App\Models\Email;
use App\Models\Note;
use App\Models\Phone;
use App\Models\Retreat;
use App\Models\SsDonation;
use App\Models\StateProvince;
use App\Models\Touchpoint;

use App\Traits\PhoneTrait;
use App\Traits\SquareSpaceTrait;

use Carbon\Carbon;


class SquarespaceDonationController extends Controller
{   use SquareSpaceTrait;
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
        $this->authorize('show-squarespace-donation');
        $donations = \App\Models\SsDonation::whereIsProcessed(0)->paginate(25, ['*'], 'ss_donations');
        $processed_donations = \App\Models\SsDonation::whereIsProcessed(1)->paginate(25, ['*'], 'ss_unprocessed_donations');
        return view('squarespace.donation.index',compact('donations','processed_donations'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-squarespace-donation');
        $donation = SsDonation::findOrFail($id);
        //dd($donation);
        return view('squarespace.donation.show', compact('donation'));

    }

    /**
     * Show a donation to confirm the retreatant for a SquareSpace order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {   $donation = \App\Models\SsDonation::findOrFail($id);
        $matching_contacts = $this->matched_contacts($donation);
        $retreats = $this->upcoming_retreats();
        return view('squarespace.donation.confirm', compact('donation','matching_contacts','retreats'));

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
