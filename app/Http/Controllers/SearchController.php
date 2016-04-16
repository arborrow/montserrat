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
	// TODO: search for parishes, dioceses, etc.
	$queries = DB::table('contact')
                ->orderBy('sort_name')
		->where('display_name', 'LIKE', '%'.$term.'%')
		->take(15)->get();

	foreach ($queries as $query)
	{
	    $results[] = [ 'id' => $query->id, 'value' => $query->display_name ];
	}

        // $query = \montserrat\Contact::orderBy('sort_name')->where('display_name','LIKE','%'.$term.'%')->list('display_name','id')->toJson();
        
return Response::json($results);
}

public function getuser() {
    $id = Input::get('response');
    // TODO: check contact_type field and redirect to appropriate parish, diocese, person, etc.
    return redirect()->action('PersonsController@show',$id);    
}
}


