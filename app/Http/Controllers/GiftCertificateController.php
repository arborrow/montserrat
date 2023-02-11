<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Traits\SquareSpaceTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PDF;


class GiftCertificateController extends Controller
{
    use SquareSpaceTrait;

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
        $this->authorize('show-gift-certificate');
        $gift_certificates = \App\Models\GiftCertificate::orderBy('issue_date')->with(['purchaser','recipient'])->get();
        
        return view('gift_certificates.index', compact('gift_certificates'));   //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create-gift-certificate');
        //dd($request);
        $purchaser = collect();
        $purchaser->name = ($request->filled('purchaser_name')) ? $request->input('purchaser_name') : null;
        $purchaser->full_address = null;
        $purchaser->email = null;

        $recipient = collect(['name'=>null, 'full_address'=>null,'email'=>null]);
        $recipient->name = ($request->filled('recipient_name')) ? $request->input('recipient_name') : null;
        $recipient->full_address = null;
        $recipient->email = null;
        
        //dd($purchaser, $recipient);
        $purchasers = ($request->filled('purchaser_name')) ? $this->matched_contacts($purchaser) : null;
        $recipients = ($request->filled('recipient_name')) ? $this->matched_contacts($recipient) : null;
        // dd($purchasers, $recipients);
        return view('gift_certificates.create',compact('purchasers','recipients'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-gift-certificate');

        $purchaser = $request->input('purchaser_name');
        $recipient = $request->input('recipient_name');
        
        // dd($purchaser, null !== $request->input('purchaser_id'), $recipient, $request->recipient_id) ;
        if (isset($purchaser) && (null !== $request->input('purchaser_id')) ) {
            if ($request->input('purchaser_id') == 0) {
                // dd('purchaser', $purchaser, $request->input('purchaser_id'), $recipient, $request->input('recipient_id'));
                $new_purchaser = new Contact();
                $names = ($request->filled('purchaser_name')) ? explode(" ", $request->purchaser_name) : null;
                if (sizeof($names) > 1) {
                    $new_purchaser->contact_type = config('polanco.contact_type.individual');
                    $new_purchaser->subcontact_type = null;
            
                    $new_purchaser->first_name = array_shift($names);
                    $new_purchaser->last_name = implode(" ",$names);
                    $new_purchaser->display_name = $purchaser;
                    $new_purchaser->sort_name = $new_purchaser->last_name . ', ' . $new_purchaser->first_name;
                    $new_purchaser->save();
                }
                $request->purchaser_id=$new_purchaser->id;
                flash('Gift certificate purchaser added')->success();
            } else {
                $new_purchaser = \App\Models\Contact::findOrFail($request->input('purchaser_id'));
            } 
        }
        // dd($purchaser, $request->purchaser_id, $recipient, $request->recipient_id, $new_purchaser->id) ;
        if (isset($recipient) && (null !== $request->input('recipient_id')) ) {
            if ($request->input('recipient_id') == 0) {
                // dd('recipient', $purchaser, $request->input('purchaser_id'), $recipient, $request->input('recipient_id'));
                $new_recipient = new Contact();
                $names = ($request->filled('recipient_name')) ? explode(" ", $request->recipient_name) : null;
                if (sizeof($names) > 1) {
                    $new_recipient->contact_type = config('polanco.contact_type.individual');
                    $new_recipient->subcontact_type = null;
                    $new_recipient->first_name = array_shift($names);
                    $new_recipient->last_name = implode(" ",$names);
                    $new_recipient->display_name = $recipient;
                    $new_recipient->sort_name = $new_recipient->last_name . ', ' . $new_recipient->first_name;
                    $new_recipient->save();
                }
                $request->recipient_id=$new_recipient->id;
                flash('Gift certificate recipient added')->success();
            } else {
                $new_recipient = \App\Models\Contact::findOrFail($request->input('recipient_id'));
            }    
        }

        // dd($request, $request->purchaser_id, $request->recipient_id);
        if ($request->purchaser_id > 0 && $request->recipient_id > 0) {
            // dd('gc', $purchaser, $request->input('purchaser_id'), $recipient, $request->input('recipient_id'));
            $gift_certificate = new \App\Models\GiftCertificate;
            $gift_certificate->purchaser_id = (isset(optional($new_purchaser)->id )) ? $new_purchaser->id : $request->input('purchaser_id');
            $gift_certificate->recipient_id = (isset(optional($new_recipient)->id )) ? $new_recipient->id : $request->input('recipient_id');
            $gift_certificate->participant_id = $request->input('participant_id');
            $gift_certificate->donation_id = $request->input('donation_id');
            $gift_certificate->sequential_number = $request->input('sequential_number');
            $gift_certificate->squarespace_order_number = $request->input('squarespace_order_number');
            $gift_certificate->purchase_date = $request->input('purchase_date');
            $gift_certificate->issue_date = $request->input('issue_date');
            $gift_certificate->expiration_date = $request->input('expiration_date');
            $gift_certificate->funded_amount = $request->input('funded_amount');
            $gift_certificate->retreat_type = $request->input('retreat_type');
            $gift_certificate->notes = $request->input('notes');    
            $gift_certificate->save();
            $gift_certificate->update_pdf();
    
            flash('Gift Certificate: <a href="'.url('/gift_certificate/'.$gift_certificate->id).'">'.$gift_certificate->certificate_number.'</a> added')->success();
            return Redirect::action([self::class, 'index']); //
   
        } else {
            return Redirect::action([\App\Http\Controllers\GiftCertificateController::class, 'create'],['purchaser_name'=>$purchaser,'recipient_name'=>$recipient]);     
        }

 
    }

    // TODO: consider if generating the pdf and saving it as an attachment might be better as an update_pdf method in the model
    /**
     * Display the gift certificate pdf.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_pdf($id)
    {
        $this->authorize('show-gift-certificate');
        $gift_certificate = \App\Models\GiftCertificate::findOrFail($id);

        $pdf = PDF::loadView('gift_certificates.certificate', compact('gift_certificate'));
        $pdf->setOptions([

        ]);
        
        $attachment = new AttachmentController;

        $attachment->update_attachment($pdf->inline($gift_certificate->certificate_number.'.pdf'), 'contact', $gift_certificate->purchaser_id, 'gift_certificate', $gift_certificate->certificate_number);

        return $pdf->inline($gift_certificate->certificate_number.'.pdf');
        

        //return view('gift_certificates.certificate', compact('gift_certificate')); 

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-gift-certificate');
        $gift_certificate = \App\Models\GiftCertificate::findOrFail($id);        

        return view('gift_certificates.show', compact('gift_certificate')); 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-gift-certificate');
        $gift_certificate = \App\Models\GiftCertificate::findOrFail($id);

        return view('gift_certificates.edit', compact('gift_certificate'));

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
        $this->authorize('update-gift-certificate');

        $gift_certificate = \App\Models\GiftCertificate::findOrFail($id);

        $gift_certificate->purchaser_id = $request->input('purchaser_id');
        $gift_certificate->recipient_id = $request->input('recipient_id');
        $gift_certificate->participant_id = $request->input('participant_id');
        $gift_certificate->donation_id = $request->input('donation_id');
        $gift_certificate->sequential_number = $request->input('sequential_number');
        $gift_certificate->squarespace_order_number = $request->input('squarespace_order_number');
        $gift_certificate->purchase_date = $request->input('purchase_date');
        $gift_certificate->issue_date = $request->input('issue_date');
        $gift_certificate->expiration_date = $request->input('expiration_date');
        $gift_certificate->funded_amount = $request->input('funded_amount');
        $gift_certificate->retreat_type = $request->input('retreat_type');
        $gift_certificate->notes = $request->input('notes');

        flash('Gift Certficiate: <a href="'.url('/gift_certificate/'.$gift_certificate->id).'">'.$gift_certificate->certificate_number.'</a> updated')->success();
        $gift_certificate->save();

        return Redirect::action([self::class, 'show'], $gift_certificate->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-gift_certificate');
        $gift_certificate = \App\Models\GiftCertificate::findOrFail($id);

        \App\Models\GiftCertificate::destroy($id);
        flash('Gift Certificate: '.$gift_certificate->certificate_number.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);

    }
}
