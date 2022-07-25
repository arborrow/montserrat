<?php

namespace App\Http\Controllers;

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
    public function create()
    {
        $this->authorize('create-gift-certificate');

        return view('gift_certificates.create');

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

        $gift_certificate = new \App\Models\GiftCertificate;
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

        $gift_certificate->save();

        flash('Gift Certificate: <a href="'.url('/gift_certificate/'.$gift_certificate->id).'">'.$gift_certificate->certificate_number.'</a> added')->success();

        return Redirect::action([self::class, 'index']); //

    }

        /**
     * Display the gift certificate pdy.
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
