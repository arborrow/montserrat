<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;

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
        $queries = \App\Models\Contact::orderBy('sort_name')->where('display_name', 'LIKE', '%'.$term.'%')->whereDeletedAt(null)->take(20)->get();
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
            $contact = \App\Models\Contact::findOrFail($id);

            return redirect()->to($contact->contact_url);
            $user = $this->createUserWithPermission('show-contact');
        }
    }

    public function results(SearchRequest $request)
    {
        $this->authorize('show-contact');
        //dd($request);
        if (! empty($request)) {
            $persons = \App\Models\Contact::filtered($request)->orderBy('sort_name')->with('attachments')->paginate(100);
            $persons->appends($request->except('page'));
            dd($persons);
        }

        return view('search.results', compact('persons'));
    }

    public function search()
    {
        $this->authorize('show-contact');

        $contact_types = \App\Models\ContactType::whereIsReserved(true)->pluck('label', 'id');
        $contact_types->prepend('N/A', '');

        $countries = \App\Models\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', '');

        $ethnicities = \App\Models\Ethnicity::orderBy('ethnicity')->pluck('ethnicity', 'id');
        $ethnicities->prepend('N/A', '');

        $genders = \App\Models\Gender::orderBy('name')->pluck('name', 'id');
        $genders->prepend('N/A', '');

        $groups = \App\Models\Group::orderBy('name')->pluck('name', 'id');
        $groups->prepend('N/A', '');

        $languages = \App\Models\Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('N/A', '');

        $occupations = \App\Models\Ppd_occupation::orderBy('name')->pluck('name', 'id');
        $occupations->prepend('N/A', '');

        $parishes = \App\Models\Contact::whereSubcontactType(config('polanco.contact_type.parish'))->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        // while probably not the most efficient way of doing this it gets me the result
        $parish_list[''] = 'N/A';
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }

        $prefixes = \App\Models\Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('N/A', '');

        $referrals = \App\Models\Referral::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $referrals->prepend('N/A', '');

        $religions = \App\Models\Religion::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $religions->prepend('N/A', '');

        $states = \App\Models\StateProvince::orderBy('name')->whereCountryId(1228)->pluck('name', 'id');
        $states->prepend('N/A', '');

        $subcontact_types = \App\Models\ContactType::orderBy('label')->whereIsReserved(false)->whereIsActive(true)->pluck('label', 'id');
        $subcontact_types->prepend('N/A', '');

        $suffixes = \App\Models\Suffix::orderBy('name')->pluck('name', 'id');
        $suffixes->prepend('N/A', '');

        return view('search.search', compact('prefixes', 'suffixes', 'parish_list', 'ethnicities', 'states', 'countries', 'genders', 'languages', 'religions', 'occupations', 'contact_types', 'subcontact_types', 'groups', 'referrals'));
    }
}
