<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uom extends Model
{   /*
    Currently the donation type label is stored in Donations.donation_description. The label field has a unique index.
    The label functions as a shortname and should be considered a foreign key relationship to Donations.donation_description.
    TODO: create and enforce fk relationship such that if the label is edited the changes cascade down into Donations.donation_description.
    To prevent data loss, when a donation type becomes inactive, the inactive type should be added to the list of active donation types and preserved (not set to null).
    Similarly, if a donation type is deleted, some thought should be given as to how the donation_description is going to be handled.
    Previously, when removing a donation type, a note was added indicating the previous donation type. All Donations should have a donation description (null is not allowed).
    The name field is more of a longer description to be used in reports.  The value field refers to the Quickbooks chart of accounts number.
    */
    use SoftDeletes;
    protected $table = 'uom';

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    // scopes for various uom types based on uom.type enum
    //  $table->enum('type', ['Data', 'Time', 'Electric current','Length','Area','Volume','Mass','Temperature','Luminosity']);

    public function scopeTime($query)
    {
        return $query->whereType('Time');
    }

    public function scopeData($query)
    {
        return $query->whereType('Data');
    }

    public function scopeElectric($query)
    {
        return $query->whereType('Electric current');
    }

    public function scopeLength($query)
    {
        return $query->whereType('Length');
    }

    public function scopeArea($query)
    {
        return $query->whereType('Area');
    }

    public function scopeVolume($query)
    {
        return $query->whereType('Volume');
    }

    public function scopeMass($query)
    {
        return $query->whereType('Mass');
    }

    // alias of scopeMass
    public function scopeWeight($query)
    {
        return $query->whereType('Mass');
    }

    public function scopeTemperature($query)
    {
        return $query->whereType('Temperature');
    }

    public function scopeLuminosity($query)
    {
        return $query->whereType('Luminosity');
    }
}
