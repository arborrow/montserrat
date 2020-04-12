<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function autocomplete(Request $request)
    {
        $this->authorize('show-contact');
        $term = $request->get('term');
        $results = [];
        $queries = \App\Contact::orderBy('sort_name')->where('display_name', 'LIKE', '%'.$term.'%')->whereDeletedAt(null)->take(20)->get();
        if (($queries->count() == 0)) {
            $results[0] = 'Add new contact (No results)';
        }
        foreach ($queries as $query) {
            $results[] = ['id' => $query->id, 'value' => $query->full_name_with_city];
        }

        return response()->json($results);
    }

    public function getuser(Request $request)
    {   //dd($request);
        $this->authorize('show-contact');
        if (empty($request->get('response'))) {
            $id = 0;
        } else {
            $id = $request->get('response');
        }

        if ($id == 0) {
            return redirect()->action('PersonController@create');
        } else {
            $contact = \App\Contact::findOrFail($id);

            return redirect($contact->contact_url);
            $user = $this->createUserWithPermission('show-contact');
        }
    }

    public function results(Request $request)
    {
        $this->authorize('show-contact');
        // dd($request);
        if (! empty($request)) {
            $persons = \App\Contact::filtered($request)->orderBy('sort_name')->with('attachments')->paginate(100);
            $persons->appends($request->except('page'));
        }

        return view('search.results', compact('persons'));
    }

    public function search()
    {
        $this->authorize('show-contact');
        $person = new \App\Contact;
        $parishes = \App\Contact::whereSubcontactType(config('polanco.contact_type.parish'))->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        $parish_list[0] = 'N/A';
        $contact_types = \App\ContactType::whereIsReserved(true)->pluck('label', 'id');
        $contact_types->prepend('N/A', 0);
        $subcontact_types = \App\ContactType::whereIsReserved(false)->whereIsActive(true)->pluck('label', 'id');
        $subcontact_types->prepend('N/A', 0);
        // while probably not the most efficient way of doing this it gets me the result
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }

        $countries = \App\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);

        $ethnicities = \App\Ethnicity::orderBy('ethnicity')->pluck('ethnicity', 'id');
        $ethnicities->prepend('N/A', 0);

        $genders = \App\Gender::orderBy('name')->pluck('name', 'id');
        $genders->prepend('N/A', 0);
        $groups = \App\Group::orderBy('name')->pluck('name', 'id');
        $groups->prepend('N/A', 0);

        $languages = \App\Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('N/A', 0);
        $referrals = \App\Referral::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $referrals->prepend('N/A', 0);
        $prefixes = \App\Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('N/A', 0);
        $religions = \App\Religion::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $religions->prepend('N/A', 0);
        $states = \App\StateProvince::orderBy('name')->whereCountryId(1228)->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $suffixes = \App\Suffix::orderBy('name')->pluck('name', 'id');
        $suffixes->prepend('N/A', 0);
        $occupations = \App\Ppd_occupation::orderBy('name')->pluck('name', 'id');
        $occupations->prepend('N/A', 0);

        //create defaults array for easier pre-populating of default values on edit/update blade
        // initialize defaults to avoid undefined index errors
        $defaults = [];
        $defaults['Home']['street_address'] = '';
        $defaults['Home']['supplemental_address_1'] = '';
        $defaults['Home']['city'] = '';
        $defaults['Home']['state_province_id'] = '';
        $defaults['Home']['postal_code'] = '';
        $defaults['Home']['country_id'] = '';
        $defaults['Home']['Phone'] = '';
        $defaults['Home']['Mobile'] = '';
        $defaults['Home']['Fax'] = '';
        $defaults['Home']['email'] = '';

        $defaults['Work']['street_address'] = '';
        $defaults['Work']['supplemental_address_1'] = '';
        $defaults['Work']['city'] = '';
        $defaults['Work']['state_province_id'] = '';
        $defaults['Work']['postal_code'] = '';
        $defaults['Work']['country_id'] = '';
        $defaults['Work']['Phone'] = '';
        $defaults['Work']['Mobile'] = '';
        $defaults['Work']['Fax'] = '';
        $defaults['Work']['email'] = '';

        $defaults['Other']['street_address'] = '';
        $defaults['Other']['supplemental_address_1'] = '';
        $defaults['Other']['city'] = '';
        $defaults['Other']['state_province_id'] = '';
        $defaults['Other']['postal_code'] = '';
        $defaults['Other']['country_id'] = '';
        $defaults['Other']['Phone'] = '';
        $defaults['Other']['Mobile'] = '';
        $defaults['Other']['Fax'] = '';
        $defaults['Other']['email'] = '';

        $defaults['Main']['url'] = '';
        $defaults['Work']['url'] = '';
        $defaults['Facebook']['url'] = '';
        $defaults['Google']['url'] = '';
        $defaults['Instagram']['url'] = '';
        $defaults['LinkedIn']['url'] = '';
        $defaults['Twitter']['url'] = '';

        foreach ($person->addresses as $address) {
            $defaults[$address->location->name]['street_address'] = $address->street_address;
            $defaults[$address->location->name]['supplemental_address_1'] = $address->supplemental_address_1;
            $defaults[$address->location->name]['city'] = $address->city;
            $defaults[$address->location->name]['state_province_id'] = $address->state_province_id;
            $defaults[$address->location->name]['postal_code'] = $address->postal_code;
            $defaults[$address->location->name]['country_id'] = $address->country_id;
        }

        foreach ($person->phones as $phone) {
            $defaults[$phone->location->name][$phone->phone_type] = $phone->phone;
        }

        foreach ($person->emails as $email) {
            $defaults[$email->location->name]['email'] = $email->email;
        }

        foreach ($person->websites as $website) {
            $defaults[$website->website_type]['url'] = $website->url;
        }
        //dd($person);

        return view('search.search', compact('prefixes', 'suffixes', 'person', 'parish_list', 'ethnicities', 'states', 'countries', 'genders', 'languages', 'defaults', 'religions', 'occupations', 'contact_types', 'subcontact_types', 'groups', 'referrals'));
    }
}
