<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Run all database health checks and display list of results
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);
        $results->put('primary_address', $this->check_primary_address());
        $results->put('primary_email', $this->check_primary_email());
        $results->put('primary_phone', $this->check_primary_phone());
        $results->put('abandoned_donations', $this->check_abandoned_donations());
        $results->put('donations_with_zero_event_id', $this->check_donations_with_zero_event_id());
        $results->put('abandoned_payments', $this->check_abandoned_payments());
        $results->put('abandoned_registrations', $this->check_abandoned_registrations());
        $results->put('duplicate_relationships', $this->check_duplicate_relationships());
        $results->put('address_with_no_country', $this->check_address_with_no_country());
        $results->put('polygamy', $this->check_polygamy());

        return view('health.index', compact('results'));   //
    }

    /**
     * Run the primary address check to ensure there is one and only one primary email address for each contact_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_primary_address()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);
        $address_primary = DB::table('address')->whereIsPrimary(1)->whereNull('deleted_at')->groupBy('contact_id')->havingRaw('count(id) > 1')->select('contact_id', 'street_address')->get();

        return $address_primary;   //
    }

    /**
     * Run the primary email check to ensure there is one and only one primary email address for each contact_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_primary_email()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);
        $email_primary = DB::table('email')->whereIsPrimary(1)->whereNull('deleted_at')->groupBy('contact_id')->havingRaw('count(id) > 1')->select('contact_id', 'email')->get();

        return $email_primary;   //
    }

    /**
     * Run the primary address check to ensure there is one and only one primary email address for each contact_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_primary_phone()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);
        $phone_primary = DB::table('phone')->whereIsPrimary(1)->whereNull('deleted_at')->groupBy('contact_id')->havingRaw('count(id) > 1')->select('contact_id', 'phone')->get();

        return $phone_primary;   //
    }

    /**
     * Run the abandoned payments check to ensure there are no payments with a deleted donation
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_abandoned_donations()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);

        $abandoned_donations = DB::table('Donations')
          ->leftJoin('contact', 'Donations.contact_id', '=', 'contact.id')
          ->where('Donations.donation_amount', '>', 0)
          ->whereNotNull('contact.deleted_at')
          ->whereNull('Donations.deleted_at')
          ->select('Donations.donation_id', 'Donations.contact_id', 'contact.sort_name', 'Donations.donation_amount', 'Donations.donation_date')
          ->get();

        return $abandoned_donations;   //
    }

    /**
     * Run the abandoned payments check to ensure there are no payments with a deleted donation
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_donations_with_zero_event_id()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);

        $donations_with_zero_event_id = DB::table('Donations')
          ->leftJoin('contact', 'Donations.contact_id', '=', 'contact.id')
          ->where('Donations.event_id', '=', 0)
          ->whereNull('contact.deleted_at')
          ->whereNull('Donations.deleted_at')
          ->select('Donations.donation_id', 'Donations.contact_id', 'contact.sort_name', 'Donations.donation_amount', 'Donations.donation_date')
          ->get();

        return $donations_with_zero_event_id;   //
    }

    /**
     * Run the abandoned payments check to ensure there are no payments with a deleted donation
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_abandoned_payments()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);

        $abandoned_payments = DB::table('Donations_payment')
        ->leftJoin('Donations', 'Donations.donation_id', '=', 'Donations_payment.donation_id')
        ->where('Donations_payment.payment_amount', '>', 0)
        ->whereNull('Donations_payment.deleted_at')
        ->whereNotNull('Donations.deleted_at')
        ->select('Donations.contact_id', 'Donations_payment.donation_id', 'Donations.donation_amount', 'Donations_payment.payment_id', 'Donations_payment.payment_amount')
        ->get();

        return $abandoned_payments;   //
    }

    /**
     * Run the abandoned registrations check to ensure there are no registrations (participant) with a deleted contact
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_abandoned_registrations()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);

        $abandoned_registrations = DB::table('participant')
          ->leftJoin('contact', 'participant.contact_id', '=', 'contact.id')
          ->whereNull('participant.deleted_at')
          ->whereNotNull('contact.deleted_at')
          ->select('participant.contact_id', 'participant.id', 'contact.sort_name')
          ->get();

        return $abandoned_registrations;   //
    }

    /**
     * Run the duplicate relationships check to ensure there are no duplicated relationships
     * // SELECT CONCAT(contact_id_a,":",contact_id_b,":",relationship_type_id) , COUNT(*) FROM relationship WHERE deleted_at IS NULL GROUP BY (CONCAT(contact_id_a,":",contact_id_b,":",relationship_type_id)) HAVING COUNT(*)>1
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_duplicate_relationships()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);

        $duplicate_relationships = DB::table('relationship')
        ->whereNull('deleted_at')
        ->whereIsActive(1)
        ->groupBy('contact_id_a', 'contact_id_b', 'relationship_type_id')
        ->havingRaw('count(id) > 1')
        ->select('contact_id_a', 'contact_id_b', 'relationship_type_id')
        ->get();

        return $duplicate_relationships;
    }

    /**
     * Check for primary addresses with no country
     * // SELECT * FROM address WHERE country_id = 0 AND deleted_at IS NULL AND street_address IS NOT NULL AND is_primary = 1;
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_address_with_no_country()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);

        $address_with_no_country = DB::table('address')
        ->whereNull('deleted_at')
        ->whereIsPrimary(1)
        ->whereNotNull('street_address')
        ->whereCountryId(0)
        ->select('id', 'contact_id', 'street_address', 'city', 'postal_code')
        ->get();

        return $address_with_no_country;
    }

    /**
     * Check for husbands with more than one wife and wives with more than one husband
     *     // SELECT contact_id_b FROM relationship WHERE deleted_at IS NULL AND relationship_type_id=2 GROUP BY contact_id_b HAVING COUNT(contact_id_b)>1;
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function check_polygamy()
    {
        $this->authorize('show-admin-menu');
        $results = collect([]);

        $husbands = DB::table('relationship')
        ->whereNull('deleted_at')
        ->whereRelationshipTypeId(config('polanco.relationship_type.husband_wife'))
        ->groupBy('contact_id_a')
        ->havingRaw('count(id) > 1')
        ->select('id', 'contact_id_a', 'contact_id_b')
        ->get();

        $wives = DB::table('relationship')
        ->whereNull('deleted_at')
        ->whereRelationshipTypeId(config('polanco.relationship_type.husband_wife'))
        ->groupBy('contact_id_b')
        ->havingRaw('count(id) > 1')
        ->select('id', 'contact_id_a', 'contact_id_b')
        ->get();

        return

        $polygamy = $husbands->merge($wives);

        return $polygamy;
    }

    // SELECT contact_id_b FROM relationship WHERE deleted_at IS NULL AND relationship_type_id=2 GROUP BY contact_id_b HAVING COUNT(contact_id_b)>1;
}
