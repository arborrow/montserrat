<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PDF;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function retreat(): View
    {
        return view('pages.retreat');
    }

    public function reservation(): View
    {
        return view('pages.reservation');
    }

    // TODO: no action
    public function room(): View
    {
        return view('pages.room');
    }

    public function housekeeping(): View
    {
        return view('pages.housekeeping');
    }

    public function maintenance(): View
    {
        return view('pages.maintenance');
    }

    public function grounds(): View
    {
        return view('pages.grounds');
    }

    public function kitchen(): View
    {
        return view('pages.kitchen');
    }

    public function finance(): View
    {
        $this->authorize('show-donation');

        return view('pages.finance');
    }

    public function bookstore(): View
    {
        return view('pages.bookstore');
    }

    public function user(): View
    {
        return view('pages.user');
    }

    public function restricted(): View
    {
        return view('pages.restricted');
    }

    public function support(): View
    {
        return view('pages.support');
    }

    public function welcome(): View
    {
        try {
            $result = Http::timeout(1)->get('http://labs.bible.org/api/?passage=random')->getBody();
            $quote = strip_tags($result->getContents(), '<b>');
        } catch (Exception $e) {
            $quote = 'John 3:16 - For God so loved the world that he gave his only Son, so that everyone who believes in him might not perish but might have eternal life.';
        }

        return view('welcome', compact('quote'));   //
    }

    public function retreatantinforeport($idnumber): View
    {
        $this->authorize('show-contact');
        $this->authorize('show-registration');
        $retreat = \App\Models\Retreat::whereIdnumber($idnumber)->firstOrFail();

        $registrations = \App\Models\Registration::select(DB::raw('participant.*', 'contact.*'))
            ->join('contact', 'participant.contact_id', '=', 'contact.id')
            ->where('participant.event_id', '=', $retreat->id)
            ->where('participant.role_id', '=', config('polanco.participant_role_id.retreatant'))
            ->whereCanceledAt(null)
            ->with('retreat', 'retreatant.languages', 'retreatant.parish.contact_a.address_primary', 'retreatant.prefix', 'retreatant.suffix', 'retreatant.address_primary.state', 'retreatant.phones.location', 'retreatant.emails.location', 'retreatant.emergency_contact', 'retreatant.notes', 'retreatant.occupation')
            ->orderBy('contact.sort_name')
            ->orderBy('participant.notes')
            ->get();

        return view('reports.retreatantinfo2', compact('registrations'));   //
    }

    public function contact_info_report($id): View
    {
        $this->authorize('show-contact');

        $person = \App\Models\Contact::findOrFail($id);

        return view('reports.contact_info', compact('person'));
    }

    public function finance_cash_deposit($day = null)
    {
        $this->authorize('show-donation');
        if (is_null($day)) {
            $day = Carbon::now();
        } else { //ensures that we are adding dashes to string prior to parsing in response to issue #448
            $day = $this->hyphenate_date($day);
        }

        $report_date = Carbon::parse($day);
        if (empty($report_date)) {
            return redirect()->back();
        }

        $payments = \App\Models\Payment::wherePaymentDate($report_date)->whereIn('payment_description', ['Cash', 'Check', 'Wire transfer'])->with('donation')->get();
        $grand_total = $payments->sum('payment_amount');
        $grouped_payments = $payments->sortBy('donation.donation_description')->groupBy('donation.donation_description');

        return view('reports.finance.cash_deposit', compact('report_date', 'grouped_payments', 'grand_total'));
    }

    public function finance_cc_deposit($day = null)
    {
        $this->authorize('show-donation');

        if (is_null($day)) {
            $day = Carbon::now();
        } else {
            $day = $this->hyphenate_date($day);
        }

        $report_date = Carbon::parse($day);
        if (empty($report_date)) {
            return redirect()->back();
        }
        $payments = \App\Models\Payment::wherePaymentDate($report_date)->where('payment_description', '=', 'Credit Card')->with('donation')->get();
        $grand_total = $payments->sum('payment_amount');
        $grouped_payments = $payments->sortBy('donation.donation_description')->groupBy('donation.donation_description');

        return view('reports.finance.cc_deposit', compact('report_date', 'grouped_payments', 'grand_total'));   //
    }

    // TODO: why allow an empty donation id?
    public function finance_invoice($donation_id = null): View
    {
        $this->authorize('show-donation');

        $donation = \App\Models\Donation::with('payments', 'contact', 'retreat')->findOrFail($donation_id);

        return view('reports.finance.invoice', compact('donation'));
    }

    public function finance_agc_acknowledge(Request $request, $donation_id = null)
    {
        $this->authorize('show-donation');

        $donation = \App\Models\Donation::with('payments', 'contact', 'retreat')->findOrFail($donation_id);

        $snippets = \App\Models\Snippet::whereTitle('agc_acknowledge')->get();
        foreach ($snippets as $snippet) {
            $decoded = html_entity_decode($snippet->snippet, ENT_QUOTES | ENT_XML1);
            Storage::put('views/snippets/'.$snippet->title.'/'.$snippet->locale.'/'.$snippet->label.'.blade.php', $decoded);
        }

        $current_user = $request->user();
//        dd($current_user->contact_id,  $donation->donation_thank_you_sent);

        if (! empty($current_user->contact_id)) {
            if ($donation->donation_thank_you_sent == 'N') { //avoid creating another touchpoint if acknowledgement letter has already been viewed (and presumably printed and mailed)
                $agc_touchpoint = new \App\Models\Touchpoint;
                $agc_touchpoint->person_id = $donation->contact_id;
                $agc_touchpoint->staff_id = $current_user->contact_id;
                $agc_touchpoint->touched_at = Carbon::now();
                $agc_touchpoint->type = 'Letter';
                $agc_touchpoint->notes = 'AGC Acknowledgement Letter for Donation #'.$donation->donation_id;
                $agc_touchpoint->save();
                $donation['Thank You'] = 'Y';
                $donation->save();
            }
        } else {
            flash('No known contact associated with the current user\'s email. AGC acknowledgment letter touchpoint cannot be created. Verify '.$current_user->email.' is associated with a contact record and then try again.')->error()->important();

            return redirect()->back();
        }

        if ($donation->contact->preferred_language_value == 'es') {
            $dt = Carbon::now();
            $donation['today_es'] = $dt->day.' de '.$dt->locale('es')->monthName.' del '.$dt->year;
            $donation['donation_date_es'] = $donation->donation_date->day.' de '.$donation->donation_date->locale('es')->monthName.' del '.$donation->donation_date->year;

            return view('reports.finance.agc_acknowledge_es', compact('donation'));
        } else {
            return view('reports.finance.agc_acknowledge', compact('donation'));
        }
    }

    public function finance_retreatdonations($idnumber = null)
    {
        $this->authorize('show-donation');

        $retreat = \App\Models\Retreat::whereIdnumber($idnumber)->firstOrFail();
        if (isset($retreat)) {
            $donations = \App\Models\Donation::whereEventId($retreat->id)->with('contact', 'payments')->get();
            $grouped_donations = $donations->sortBy('donation_description')->groupBy('donation_description');

            return view('reports.finance.retreatdonations', compact('retreat', 'grouped_donations', 'donations'));   //
        } else {
            return redirect()->back(); //
        }
    }

    public function finance_deposits()
    {
        $this->authorize('show-donation');
        $donations = \App\Models\Donation::where('donation_description', 'Retreat Deposits')->whereDeletedAt(null)->where('donation_amount', '>', 0)->with('contact', 'payments', 'retreat')->get();
        $payments = \App\Models\Payment::whereHas('donation', function ($query) {
            $query->where('donation_description', '=', 'Retreat Deposits');
        })
            ->whereHas('donation', function ($query) {
                $query->where('donation_amount', '>', 0);
            })->with('donation.retreat', 'donation.contact')->get();
        $grouped_payments = $payments->groupBy(function ($c) {
            return '#'.$c->donation->retreat_idnumber.'-'.$c->donation->retreat_name.' ('.$c->donation->retreat_start_date.')';
        })->sortBy(function ($d) {
            return Carbon::parse($d[0]->donation->retreat_start_date);
        });

        return view('reports.finance.deposits', compact('grouped_payments', 'payments'));
    }

    public function finance_reconcile_deposit_show($event_id = null)
    {
        $this->authorize('show-donation');
        $this->authorize('show-registration');

        if (! isset($event_id)) {
            $event_id = config('polanco.event.open_deposit');
        }

        $payments = \App\Models\Payment::where('payment_amount', '>', 0)
            ->whereHas('donation', function ($query) {
                $query->where('donation_description', '=', 'Retreat Deposits');
            })
            ->whereHas('donation', function ($query) use ($event_id) {
                $query->where('event_id', '=', $event_id);
            })
            ->whereHas('donation', function ($query) {
                $query->where('donation_amount', '>', 0);
            })->with('donation.retreat', 'donation.contact')->get();
        $grouped_payments = $payments->groupBy(function ($c) {
            return '#'.$c->donation->retreat_idnumber.'-'.$c->donation->retreat_name.' ('.$c->donation->retreat_start_date.')';
        })->sortBy(function ($d) {
            return Carbon::parse($d[0]->donation->retreat_start_date);
        });
        $registrations = \App\Models\Registration::whereEventId($event_id)->whereCanceledAt(null)->orderBy('contact_id')->get();
        $pg = $payments->groupBy('donation.contact_id')->sortBy('donation.contact_id');
        $rg = $registrations->groupBy('contact_id')->sortBy('contact_id');
        $diffpg = $pg->diffKeys($rg); //payments with no registration
        $diffrg = $rg->diffKeys($pg); //regisrations with no payments

        return view('reports.finance.reconcile_deposits', compact('diffpg', 'diffrg'));
    }

    public function retreatlistingreport($idnumber): View
    {
        $this->authorize('show-contact');

        $retreat = \App\Models\Retreat::whereIdnumber($idnumber)->firstOrFail();

        $retreatants = \App\Models\Registration::whereCanceledAt(null)
            ->whereEventId($retreat->id)
            ->whereRoleId(config('polanco.participant_role_id.retreatant'))
            ->whereStatusId(config('polanco.registration_status_id.registered'))
            ->with('retreat', 'retreatant')
            ->get();
        $ambassadors = \App\Models\Registration::whereCanceledAt(null)
                ->whereEventId($retreat->id)
                ->whereRoleId(config('polanco.participant_role_id.ambassador'))
                ->whereStatusId(config('polanco.registration_status_id.registered'))
                ->with('retreat', 'retreatant')
                ->get();
        $registrations = $retreatants->merge($ambassadors);
        $registrations = $registrations->sortBy('retreatant.sort_name');

        return view('reports.retreatlisting', compact('registrations'));   //
    }

    public function retreatrosterreport($idnumber): View
    {
        $this->authorize('show-contact');

        $retreat = \App\Models\Retreat::whereIdnumber($idnumber)->firstOrFail();
        $retreatants = \App\Models\Registration::whereCanceledAt(null)
            ->whereEventId($retreat->id)
            ->whereRoleId(config('polanco.participant_role_id.retreatant'))
            ->whereStatusId(config('polanco.registration_status_id.registered'))
            ->with('retreat', 'retreatant')
            ->get();
        $ambassadors = \App\Models\Registration::whereCanceledAt(null)
                ->whereEventId($retreat->id)
                ->whereRoleId(config('polanco.participant_role_id.ambassador'))
                ->whereStatusId(config('polanco.registration_status_id.registered'))
                ->with('retreat', 'retreatant')
                ->get();
        $registrations = $retreatants->merge($ambassadors);
        $registrations = $registrations->sortBy('retreatant.sort_name');

        return view('reports.retreatroster', compact('registrations'));   //
    }

    public function retreatregistrations($idnumber): View
    {
        $this->authorize('show-registration');

        $retreat = \App\Models\Retreat::whereIdnumber($idnumber)->firstOrFail();
        $registrations = \App\Models\Registration::whereCanceledAt(null)
            ->whereEventId($retreat->id)
            ->whereRoleId(config('polanco.participant_role_id.retreatant'))
            ->whereStatusId(config('polanco.registration_status_id.registered'))
            ->with('retreat', 'retreatant')
            ->orderBy('register_date')
            ->get();

        return view('reports.retreatregistrations', compact('registrations'));   //
    }

    public function eoy_acknowledgment($contact_id = null, $start_date = null, $end_date = null)
    {
        $this->authorize('show-donation');

        if (! is_null($start_date)) {
            $start_date = $this->hyphenate_date($start_date);
        }

        if (! is_null($end_date)) {
            $end_date = $this->hyphenate_date($end_date);
        }

        $start_date = (is_null($start_date)) ? Carbon::now()->subYear()->month(1)->day(1) : Carbon::parse($start_date);
        $end_date = (is_null($end_date)) ? Carbon::now()->subYear()->month(12)->day(31) : Carbon::parse($end_date);

        $current_user = auth()->user();

        $contact = \App\Models\Contact::findOrFail($contact_id);
        $payments = \App\Models\Payment::with('donation.contact', 'donation.retreat')
        ->whereHas('donation', function ($query) use ($contact_id) {
            $query->whereContactId($contact_id);
        })
        ->where('payment_date', '>=', $start_date->toDateString())
        ->where('payment_date', '<=', $end_date->toDateString())->get();

        $acknowlegment_touchpoint = new \App\Models\Touchpoint;
        $acknowlegment_touchpoint->person_id = $contact_id;
        $acknowlegment_touchpoint->staff_id = $current_user->contact_id;
        $acknowlegment_touchpoint->touched_at = Carbon::now();
        $acknowlegment_touchpoint->type = 'Letter';
        $acknowlegment_touchpoint->notes = 'End-of-year Donation Acknowledgement Letter: '.$start_date->toDateString().' to '.$end_date->toDateString();
        $acknowlegment_touchpoint->save();

        $snippets = \App\Models\Snippet::whereTitle('eoy_acknowledgment')->get();
        foreach ($snippets as $snippet) {
            $decoded = html_entity_decode($snippet->snippet, ENT_QUOTES | ENT_XML1);
            Storage::put('views/snippets/'.$snippet->title.'/'.$snippet->locale.'/'.$snippet->label.'.blade.php', $decoded);
        }

        // TODO: implement a Spanish version of the email at the end, commenting out for now
        /*        if ($donation->contact->preferred_language_value == 'es') {
                    $dt = Carbon::now();
                    $donation['today_es'] = $dt->day.' de '.$dt->locale('es')->monthName.' del '.$dt->year;
                    $donation['donation_date_es'] = $donation->donation_date->day.' de '.$donation->donation_date->locale('es')->monthName.' del '.$donation->donation_date->year;

                    return view('reports.finance.acknowledgment_es', compact('payments'));
                } else {
                    return view('reports.finance.acknowledgment', compact('donation'));
                }
        */
        $montserrat = \App\Models\Contact::findOrFail(config('polanco.self.id'));
        // dd($montserrat);
        $pdf = PDF::loadView('reports.finance.eoy_acknowledgment', compact('payments', 'contact', 'montserrat', 'start_date', 'end_date'));
        $pdf->setOptions([
            'header-html' => view('pdf._header'),
            'footer-html' => view('pdf._footer'),
        ]);
        $now = Carbon::now();
        $attachment = new AttachmentController;
        $attachment->update_attachment($pdf->inline(), 'contact', $contact->id, 'acknowledgment', $acknowlegment_touchpoint->notes);

        return $pdf->inline();
        // return view('reports.finance.acknowledgment', compact('payments','contact', 'montserrat','start_date','end_date'));
    }

    public function config_index(): View
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.index');
    }

    public function config_application(): View
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.application');
    }

    public function config_mail(): View
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.mail');
    }

    public function config_gate(): View
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.gate');
    }

    public function config_google_calendar(): View
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.google_calendar');
    }

    public function config_google_client(): View
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.google_client');
    }

    public function config_mailgun(): View
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.mailgun');
    }

    public function config_twilio(): View
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.twilio');
    }

    /**
     * Hyphenates an 8 digit number to yyyy-mm-dd
     * Ensures dashes added to create hyphenated string prior to parsing date if unhyphanted
     * If already hyphenated and valid format of yyyy-mm-dd returns hyphanated string
     * Helps address issue #448
     *
     * @return string $hyphenated_date
     */
    public function hyphenate_date(int|string $unhyphenated_date)
    {
        if ((strpos($unhyphenated_date, '-') == 0) && (strlen($unhyphenated_date) == 8) && is_numeric($unhyphenated_date)) {
            $hyphenated_date = substr($unhyphenated_date, 0, 4).'-'.substr($unhyphenated_date, 4, 2).'-'.substr($unhyphenated_date, 6, 2);

            return $hyphenated_date;
        } else {
            if ($this->validateDate($unhyphenated_date)) { //already hyphenated
                $hyphenated_date = $unhyphenated_date;

                return $hyphenated_date;
            } else {
                return null;
            }
        }
    }

    public function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }
}
