<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;

use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Socialite;
use Auth;

class TouchpointsController extends Controller
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
        //
        $touchpoints = \montserrat\Touchpoint::orderBy('touched_at', 'desc')->with('person','staff')->get();
        return view('touchpoints.index',compact('touchpoints'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $staff = \montserrat\Contact::with('groups')->whereHas('groups', function ($query) {$query->where('group_id','=',GROUP_ID_STAFF);})->orderBy('sort_name')->lists('sort_name','id');
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $persons = \montserrat\Contact::orderBy('sort_name')->lists('sort_name','id');
        return view('touchpoints.create',compact('staff','persons'));  

    }

    public function group_create()
    {
        //
        $staff = \montserrat\Contact::with('groups')->whereHas('groups', function ($query) {$query->where('group_id','=',GROUP_ID_STAFF);})->orderBy('sort_name')->lists('sort_name','id');
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $groups = \montserrat\Group::orderBy('title')->lists('title','id');
        return view('touchpoints.group_add',compact('staff','groups'));  

    }
    
    public function group_add($group_id)
    {
        $current_user = Auth::user();
        $user_email = \montserrat\Email::whereEmail($current_user->email)->first();
        $defaults['contact_id'] = $group_id;
        if (empty($user_email->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $user_email->contact_id;
        }
        
        
        $staff = \montserrat\Contact::with('groups')->whereHas('groups', function ($query) {$query->where('group_id','=',GROUP_ID_STAFF);})->orderBy('sort_name')->lists('sort_name','id');
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $groups = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->lists('sort_name','id');
        return view('touchpoints.group_add',compact('staff','groups','defaults'));  

    }
    
    public function add($id)
    {
        //
        
        $current_user = Auth::user();
        $user_email = \montserrat\Email::whereEmail($current_user->email)->first();
        $defaults['contact_id'] = $id;
        if (empty($user_email->contact_id)) {
            $defaults['user_id'] = 0;
        } else {
            $defaults['user_id'] = $user_email->contact_id;
        }
        
        $staff = \montserrat\Contact::with('groups')->whereHas('groups', function ($query) {$query->where('group_id','=',GROUP_ID_STAFF);})->orderBy('sort_name')->lists('sort_name','id');
        // TODO: replace this with an autocomplete text box for performance rather than a dropdown box
        $persons = \montserrat\Contact::orderBy('sort_name')->lists('sort_name','id');
        return view('touchpoints.create',compact('staff','persons','defaults'));  

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
        'touched_at' => 'required|date',
        'person_id' => 'required|integer|min:0',
        'staff_id' => 'required|integer|min:0',
        'type' => 'in:Email,Call,Letter,Face,Other'
        ]);

    $touchpoint = new \montserrat\Touchpoint;
    $touchpoint->person_id= $request->input('person_id');
    $touchpoint->staff_id= $request->input('staff_id');
    $touchpoint->touched_at= Carbon::parse($request->input('touched_at'));
    $touchpoint->type = $request->input('type');
    $touchpoint->notes= $request->input('notes');
    
    $touchpoint->save();
    
    return Redirect::action('TouchpointsController@index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $touchpoint = \montserrat\Touchpoint::with('staff','person')->findOrFail($id);
        return view('touchpoints.show',compact('touchpoint'));//

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $touchpoint = \montserrat\Touchpoint::with('staff','person')->findOrFail($id);
        $staff = \montserrat\Contact::with('groups')->whereHas('groups', function ($query) {$query->where('group_id','=',GROUP_ID_STAFF);})->orderBy('sort_name')->lists('sort_name','id');
        $persons = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name')->lists('sort_name','id');

        return view('touchpoints.edit',compact('touchpoint','staff','persons'));//

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
        //
        $this->validate($request, [
        'touched_at' => 'required|date',
        'person_id' => 'required|integer|min:0',
        'staff_id' => 'required|integer|min:0',
        'type' => 'in:Email,Call,Letter,Face,Other'
        ]);
        $touchpoint = \montserrat\Touchpoint::findOrFail($request->input('id'));
    
        $touchpoint->person_id= $request->input('person_id');
        $touchpoint->staff_id= $request->input('staff_id');
        $touchpoint->touched_at= $request->input('touched_at');
        $touchpoint->type = $request->input('type');
        $touchpoint->notes= $request->input('notes');

        $touchpoint->save();
    
    return Redirect::action('TouchpointsController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        \montserrat\Touchpoint::destroy($id);
       return Redirect::action('TouchpointsController@index');
    
    }
}
