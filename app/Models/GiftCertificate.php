<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use PDF;

class GiftCertificate extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'gift_certificate';

    protected $appends = ['certificate_number'];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'datetime',
            'issue_date' => 'datetime',
            'expiration_date' => 'datetime',
        ];
    }

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
        return (isset($this->funded_amount)) ? number_format($this->funded_amount, 2) : number_format(0, 2);
    }

    public function getCertificateNumberAttribute()
    {
        return (isset($this->squarespace_order_number)) ? $this->issue_date->year.'-'.$this->squarespace_order_number : $this->issue_date->year.'-'.$this->sequential_number;
    }

    public function update_pdf()
    {
        $gift_certificate = $this;
        $pdf = PDF::loadView('gift_certificates.certificate', compact('gift_certificate'));
        $pdf->setOptions([]);

        $attachment = new \App\Http\Controllers\AttachmentController;
        $attachment->update_attachment($pdf->inline($gift_certificate->certificate_number.'.pdf'), 'contact', $gift_certificate->purchaser_id, 'gift_certificate', $gift_certificate->certificate_number);
    }

    // active gift certificates are those that have not been applied to a particular registration that have not yet expired
    public function scopeActive($query)
    {
        $query->whereNull('participant_id')->where('expiration_date', '>=', now());
    }

    // applied gift certificates have been applied to be used as a credit for a particular registration
    public function scopeApplied($query)
    {
        $query->whereNotNull('participant_id');
    }

    // applied gift certificates have been applied to be used as a credit for a particular registration
    public function scopeExpired($query)
    {
        $query->whereNull('participant_id')->where('expiration_date', '<', now());
    }
}
