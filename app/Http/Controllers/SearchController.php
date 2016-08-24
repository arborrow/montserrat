<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Response;

class SearchController extends Controller {

public function autocomplete(){
	$term = Input::get('term');
	
	$results = array();
	$results[0]='Add new person';
        // TODO: search for parishes, dioceses, etc.
	$queries = DB::table('contact')
                ->orderBy('sort_name')
		->where('display_name', 'LIKE', '%'.$term.'%')
                ->whereNull('deleted_at')
		->take(20)->get();
        $queries = \montserrat\Contact::orderBy('sort_name')->where('display_name','LIKE','%'.$term.'%')->whereDeletedAt(NULL)->take(20)->get();
	foreach ($queries as $query) {
                $results[] = [ 'id' => $query->id, 'value' => $query->full_name ];
            
        }

        // $query = \montserrat\Contact::orderBy('sort_name')->where('display_name','LIKE','%'.$term.'%')->list('display_name','id')->toJson();
        
return Response::json($results);
}

public function getuser() {
    if (empty(Input::get('response'))) {
        $id = 0;
    } else {
        $id = Input::get('response');
    }
    // TODO: check contact_type field and redirect to appropriate parish, diocese, person, etc.
    if ($id==0) {
        return redirect()->action('PersonsController@create');
    } else {
        $contact = \montserrat\Contact::findOrFail($id);
        if ($contact->contact_type == CONTACT_TYPE_INDIVIDUAL) {
            return redirect()->action('PersonsController@show',$id);
        }
        switch ($contact->subcontact_type) {
            case CONTACT_TYPE_PARISH : return redirect()->action('ParishesController@show',$id); break;
            case CONTACT_TYPE_DIOCESE: return redirect()->action('DiocesesController@show',$id); break;
            case CONTACT_TYPE_VENDOR : return redirect()->action('VendorsController@show',$id); break;
            default : return redirect()->action('OrganizationsController@show',$id);
            
        }
    }
}
}


