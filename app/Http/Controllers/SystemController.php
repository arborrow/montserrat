<?php

namespace App\Http\Controllers;

class SystemController extends Controller
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
        //
    }

    /**
     * Displays phpinfo.
     *
     * @return \Illuminate\Http\Response
     */
    public function phpinfo()
    {
        phpinfo();
    }

    public static function is_twilio_enabled()
    {
        if (null !== config('settings.twilio_sid') && null !== config('settings.twilio_token')) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_google_client_enabled()
    {
        if (null !== config('services.google.client_id') && null !== config('services.google.client_secret') && null !== config('services.google.redirect')) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_mailgun_enabled()
    {
        if (null !== config('services.mailgun.domain') && null !== config('services.mailgun.secret')) {
            return true;
        } else {
            return false;
        }
    }

    public function offeringdedup_index()
    {
        $this->authorize('show-offeringdedup');

        $offeringdedup = \App\Offeringdedup::orderBy('count', 'desc')->paginate(50);
        // dd($dioceses);
        return view('offeringdedup.index', compact('offeringdedup'));
    }

    public function offeringdedup_show($contact_id = null, $event_id = null)
    {
        $this->authorize('show-offeringdedup');
        $donations = \App\Donation::whereEventId($event_id)->whereContactId($contact_id)->whereDonationDescription('Retreat Offering')->get();
        $combo = $contact_id.'-'.$event_id;

        return view('offeringdedup.show', compact('donations', 'combo'));
    }
}
