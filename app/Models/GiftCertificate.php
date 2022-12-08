<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use PDF;
use App\Models\AttachmentController;

class GiftCertificate extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'gift_certificate';
    protected $casts = [
        'purchase_date' => 'datetime',
        'issue_date' => 'datetime',
        'expiration_date' => 'datetime',
    ];  
    protected $appends = ['certificate_number'];

    public function purchaser()
    {
        return $this->belongsTo(Contact::class, 'purchaser_id', 'id');
    }

    public function recipient()
    {
        return $this->belongsTo(Contact::class, 'recipient_id', 'id');
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'participant_id', 'id');
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id', 'id');
    }

    public function squarespace_order()
    {
        return $this->belongsTo(SquarespaceOrder::class, 'squarespace_order_number', 'order_number');
    }

    public function getFormattedFundedAmountAttribute()
    {
        return (isset($this->funded_amount)) ? number_format($this->funded_amount,2) : number_format(0,2);        
    }

    public function getCertificateNumberAttribute()
    {
        return (isset($this->squarespace_order_number)) ? $this->issue_date->year . '-' . $this->squarespace_order_number : $this->issue_date->year . '-' . $this->sequential_number;        
    }

    public function update_pdf() {
        $gift_certificate = $this;
        $pdf = PDF::loadView('gift_certificates.certificate', compact('gift_certificate'));
        $pdf->setOptions([]);
        
        $attachment = new \App\Http\Controllers\AttachmentController;
        $attachment->update_attachment($pdf->inline($gift_certificate->certificate_number.'.pdf'), 'contact', $gift_certificate->purchaser_id, 'gift_certificate', $gift_certificate->certificate_number);


    }
}
