<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

#[Middleware('auth')]
class SystemController extends Controller
{
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
     */
    #[Authorize('show-admin-menu')]
    public function phpinfo(): View
    {
        return view('admin.config.phpinfo');
    }

    public static function is_twilio_enabled()
    {
        if (config('settings.twilio_sid') !== null && config('settings.twilio_token') !== null) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_google_client_enabled()
    {
        if (config('services.google.client_id') !== null && config('services.google.client_secret') !== null && config('services.google.redirect') !== null) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_mailgun_enabled()
    {
        if (config('services.mailgun.domain') !== null && config('services.mailgun.secret') !== null) {
            return true;
        } else {
            return false;
        }
    }

    #[Authorize('show-offeringdedup')]
    public function offeringdedup_index(): View
    {
        $offeringdedup = \App\Models\TmpOfferingDedup::orderBy('count', 'desc')->paginate(50);

        // dd($dioceses);
        return view('offeringdedup.index', compact('offeringdedup'));
    }

    #[Authorize('show-offeringdedup')]
    public function offeringdedup_show($contact_id = null, $event_id = null): View
    {
        $donations = \App\Models\Donation::whereEventId($event_id)->whereContactId($contact_id)->whereDonationDescription('Retreat Funding')->get();
        $combo = $contact_id.'-'.$event_id;

        return view('offeringdedup.show', compact('donations', 'combo'));
    }
}
