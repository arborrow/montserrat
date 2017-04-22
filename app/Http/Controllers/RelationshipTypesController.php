<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;
use Illuminate\Support\Facades\URL;

class RelationshipTypesController extends Controller
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
        $this->authorize('show-relationshiptype');
        $relationship_types = \montserrat\RelationshipType::whereIsActive(1)->orderBy('description')->get();
        return view('relationships.types.index', compact('relationship_types'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-relationshiptype');
        $contact_types = \montserrat\ContactType::OrderBy('name')->pluck('name', 'name');
        return view('relationships.types.create', compact('contact_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-relationshiptype');
        $this->validate($request, [
            'description' => 'required',
            'name_a_b' => 'required',
            'label_a_b' => 'required',
            'name_b_a' => 'required',
            'label_b_a' => 'required',
            'contact_type_a' => 'required',
            'contact_type_b' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_reserved' => 'integer|min:0|max:1'
        ]);
        
        $relationship_type = new \montserrat\RelationshipType;
        $relationship_type->description = $request->input('description');
        $relationship_type->name_a_b = $request->input('name_a_b');
        $relationship_type->label_a_b = $request->input('label_a_b');
        
        $contact_type_a = \montserrat\ContactType::whereName($request->input('contact_type_a'))->firstOrFail();
        $contact_type_b = \montserrat\ContactType::whereName($request->input('contact_type_b'))->firstOrFail();
        
        if ($contact_type_a->is_reserved>0) {   // Explanation: primary type of Individual, Organization, or Household
            $relationship_type->contact_type_a = $contact_type_a->name;
        } else {
            // WARNING: assumes that if it is not a primary contact type then it is an organization (this may not always be true in the future, but for now ...
            $relationship_type->contact_type_a = 'Organization';
            $relationship_type->contact_sub_type_a = $contact_type_a->name;
        }
        
        if ($contact_type_b->is_reserved>0) {   // Explanation: primary type of Individual, Organization, or Household
            $relationship_type->contact_type_b = $contact_type_b->name;
        } else {
            // WARNING: assumes that if it is not a primary contact type then it is an organization (this may not always be true in the future, but for now ...
            $relationship_type->contact_type_b = 'Organization';
            $relationship_type->contact_sub_type_b = $contact_type_b->name;
        }
        
        $relationship_type->name_b_a = $request->input('name_b_a');
        $relationship_type->label_b_a = $request->input('label_b_a');
        $relationship_type->contact_type_b = $request->input('contact_type_b');
        
        $relationship_type->is_active = $request->input('is_active');
        $relationship_type->is_reserved = $request->input('is_reserved');
       
        $relationship_type->save();
       
        return Redirect::action('RelationshipTypesController@index');//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-relationshiptype');
        $relationship_type = \montserrat\RelationshipType::findOrFail($id);
        $relationships = \montserrat\Relationship::whereRelationshipTypeId($id)->orderBy('contact_id_a')->with('contact_a', 'contact_b')->paginate(100);
        return view('relationships.types.show', compact('relationship_type', 'relationships'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-relationshiptype');
        $relationship_type = \montserrat\RelationshipType::findOrFail($id);
        //dd($relationship_type);
        return view('relationships.types.edit', compact('relationship_type'));
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
        $this->authorize('update-relationshiptype');
        $this->validate($request, [
            'description' => 'required',
            'name_a_b' => 'required',
            'label_a_b' => 'required',
            'name_b_a' => 'required',
            'label_b_a' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_reserved' => 'integer|min:0|max:1'
        ]);
        
        $relationship_type = \montserrat\RelationshipType::findOrFail($request->input('id'));
        $relationship_type->description = $request->input('description');
        $relationship_type->name_a_b = $request->input('name_a_b');
        $relationship_type->label_a_b = $request->input('label_a_b');
        $relationship_type->name_b_a = $request->input('name_b_a');
        $relationship_type->label_b_a = $request->input('label_b_a');
        $relationship_type->is_active = $request->input('is_active');
        $relationship_type->is_reserved = $request->input('is_reserved');
       
        $relationship_type->save();
    
        return Redirect::action('RelationshipTypesController@index');//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-relationshiptype');
        \montserrat\RelationshipType::destroy($id);
        return Redirect::action('RelationshipTypesController@index');
    }
    
    public function add($id, $a = null, $b = null)
    {
        $this->authorize('create-relationship');
        $relationship_type = \montserrat\RelationshipType::findOrFail($id);
        $ignored_subtype = [];
            $ignored_subtype["Child"] = RELATIONSHIP_TYPE_CHILD_PARENT;
            $ignored_subtype["Parent"] = RELATIONSHIP_TYPE_CHILD_PARENT;
            $ignored_subtype["Husband"] = RELATIONSHIP_TYPE_HUSBAND_WIFE;
            $ignored_subtype["Wife"] = RELATIONSHIP_TYPE_HUSBAND_WIFE;
            $ignored_subtype["Sibling"] = RELATIONSHIP_TYPE_SIBLING;
            $ignored_subtype["Parishioner"] = RELATIONSHIP_TYPE_PARISHIONER;

        if (in_array($relationship_type->name_a_b, $ignored_subtype)) {
            $subtype_a_name = null;
        } else {
            $subtype_a_name = $relationship_type->name_a_b;
        }
        if (in_array($relationship_type->name_b_a, $ignored_subtype)) {
            $subtype_b_name = null;
        } else {
            $subtype_b_name = $relationship_type->name_b_a;
        }
        
        if (!isset($a) or $a==0) {
            $contact_a_list = $this->get_contact_type_list($relationship_type->contact_type_a, $subtype_a_name);
        } else {
            $contacta = \montserrat\Contact::findOrFail($a);
            $contact_a_list[$contacta->id] = $contacta->sort_name;
        }
        if (!isset($b) or $b==0) {
            $contact_b_list = $this->get_contact_type_list($relationship_type->contact_type_b, $subtype_b_name);
        } else {
            $contactb = \montserrat\Contact::findOrFail($b);
            $contact_b_list[$contactb->id] = $contactb->sort_name;
        }
        
        return view('relationships.types.add', compact('relationship_type', 'contact_a_list', 'contact_b_list'));//
    }
    public function addme(Request $request)
    {
        $this->authorize('create-relationship');
        $this->validate($request, [
            'contact_id' => 'integer|min:1|required',
            'relationship_type' => 'required|in:Child,Parent,Husband,Wife,Sibling,Employee,Volunteer,Parishioner'
        ]);
        $relationship_type = $request->input('relationship_type');
        $contact_id = $request->input('contact_id');
        switch ($relationship_type) {
            case 'Child':
                $relationship_type_id = RELATIONSHIP_TYPE_CHILD_PARENT;
                return Redirect::route('relationship_type.add', ['id' => $relationship_type_id,'a' => $contact_id]);
                break;
            case 'Parent':
                $relationship_type_id = RELATIONSHIP_TYPE_CHILD_PARENT;
                return Redirect::route('relationship_type.add', ['id' => $relationship_type_id,'a' => 0, 'b'=> $contact_id]);
                break;
            case 'Husband':
                $relationship_type_id = RELATIONSHIP_TYPE_HUSBAND_WIFE;
                return Redirect::route('relationship_type.add', ['id' => $relationship_type_id,'a' => $contact_id]);
                break;
            case 'Wife':
                $relationship_type_id = RELATIONSHIP_TYPE_HUSBAND_WIFE;
                return Redirect::route('relationship_type.add', ['id' => $relationship_type_id,'a' => 0, 'b'=> $contact_id]);
                break;
            case 'Sibling':
                $relationship_type_id = RELATIONSHIP_TYPE_SIBLING;
                return Redirect::route('relationship_type.add', ['id' => $relationship_type_id,'a' => $contact_id]);
                break;
            case 'Employee':
                $relationship_type_id = RELATIONSHIP_TYPE_STAFF;
                return Redirect::route('relationship_type.add', ['id' => $relationship_type_id,'a' => $contact_id]);
                break;
            case 'Volunteer':
                $relationship_type_id = RELATIONSHIP_TYPE_VOLUNTEER;
                return Redirect::route('relationship_type.add', ['id' => $relationship_type_id,'a' => 0, 'b'=> $contact_id]);
                break;
            case 'Parishioner':
                $relationship_type_id = RELATIONSHIP_TYPE_PARISHIONER;
                return Redirect::route('relationship_type.add', ['id' => $relationship_type_id,'a' => 0, 'b'=> $contact_id]);
                break;
            default:
                abort(404);
        }
    }
    
    public function make(Request $request)
    {
        $this->authorize('create-relationship');
        $this->validate($request, [
            'contact_a_id' => 'integer|min:0|required',
            'contact_b_id' => 'integer|min:0|required'
        ]);
        // a very hacky way to get the contact_id of the user that we are creating a relationship for
        // this allows the ability to redirect back to that user
        $url_previous = URL::previous();
        $url_param = strpos($url_previous, 'add')+4;
        $url_right = substr($url_previous, $url_param);
        if (strpos($url_right, '/')>0) {
            $url_a_param = substr($url_right, 0, strpos($url_right, '/'));
            $url_b_param = substr($url_right, strpos($url_right, '/')+1);
            $contact_id = $url_b_param;
        } else {
            $url_a_param = $url_right;
            $url_b_param = 0;
            $contact_id = $url_a_param;
        }
        //dd($url_right,$url_a_param, $url_b_param);
        $relationship = new \montserrat\Relationship;
        $relationship->contact_id_a = $request->input('contact_a_id');
        $relationship->contact_id_b = $request->input('contact_b_id');
        $relationship->relationship_type_id = $request->input('relationship_type_id');
        $relationship->is_active = 1;
        $relationship->save();
       
        return Redirect::route('person.show', ['id' => $contact_id]);
    }
    public function get_contact_type_list($contact_type = 'Individual', $contact_subtype = null)
    {
        $this->authorize('show-contact');
        switch ($contact_type) {
            case 'Household':
                $households = \montserrat\Contact::whereContactType(CONTACT_TYPE_HOUSEHOLD)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                return $households;
                break;
            case 'Organization':
                switch ($contact_subtype) {
                    case 'Parish':
                        $parish_list = [];
                        $parishes = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PARISH)->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
                        $parish_list = array_pluck($parishes->toArray(), 'full_name_with_city', 'id');
                        /* foreach($parishes as $parish) {
                            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
                        } */
                        return $parish_list;
                        break;
                    case 'Diocese':
                        $dioceses = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_DIOCESE)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                        return $dioceses;
                        break;
                    case 'Province':
                        $provinces = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PROVINCE)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                        return $provinces;
                        break;
                    case 'Community':
                        $communities = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_COMMUNITY)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                        return $communities;
                        break;
                    case 'Retreat House':
                        $retreat_houses = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_RETREAT_HOUSE)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                        return $retreat_houses;
                        break;
                    case 'Vendor':
                        $vendors = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_VENDOR)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                        return $vendors;
                        break;
                    case 'Religious-Catholic':
                        $religious_catholic = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_RELIGIOUS_CATHOLIC)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                        return $religious_catholic;
                        break;
                    case 'Religious-Non-Catholic':
                        $religious_non_catholic = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_RELIGIOUS_NONCATHOLIC)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                        return $religious_non_catholic;
                        break;
                    case 'Foundation':
                        $foundations = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_FOUNDATION)->orderBy('organization_name', 'asc')->pluck('organization_name', 'id');
                        return $religious_non_catholic;
                        break;
                    //default NULL (generic organization)
                        
                    default:
                        $organizations = \montserrat\Contact::whereContactType(CONTACT_TYPE_ORGANIZATION)->orderBy('organization_name', 'asc')->get();
                        $organization_list = array_pluck($organizations->toArray(), 'full_name_with_city', 'id');
                        //dd($temp);
                        return $organization_list;
                        break;
                }
                break;
            // default Individual
            default:
                switch ($contact_subtype) {
                    case 'Bishop':
                        $bishops = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_BISHOP);
                        })->pluck('sort_name', 'id');
                        return $bishops;
                        break;
                    case 'Priest':
                        $priests = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_PRIEST);
                        })->pluck('sort_name', 'id');
                        return $priests;
                        break;
                    case 'Deacon':
                        $deacons = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_DEACON);
                        })->pluck('sort_name', 'id');
                        return $deacons;
                        break;
                    case 'Pastor':
                        $pastors = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_PASTOR);
                        })->pluck('sort_name', 'id');
                        return $pastors;
                        break;
                    case 'Innkeeper':
                        $innkeepers = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_INNKEEPER);
                        })->pluck('sort_name', 'id');
                        return $innkeepers;
                        break;
                    case 'Assistant':
                        $assistants = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_ASSISTANT);
                        })->pluck('sort_name', 'id');
                        return $assistants;
                        break;
                    case 'Director':
                        $directors = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_DIRECTOR);
                        })->pluck('sort_name', 'id');
                        return $directors;
                        break;
                    case 'Captain':
                        $captains = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_CAPTAIN);
                        })->pluck('sort_name', 'id');
                        return $captains;
                        break;
                    case 'Jesuit':
                        $jesuits = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_JESUIT);
                        })->pluck('sort_name', 'id');
                        return $jesuits;
                        break;
                    case 'Provincial':
                        $provincials = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_PROVINCIAL);
                        })->pluck('sort_name', 'id');
                        return $provincials;
                        break;
                    case 'Superior':
                        $superiors = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_SUPERIOR);
                        })->pluck('sort_name', 'id');
                        return $superiors;
                        break;
                    case 'Board member':
                        $board_members = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_BOARD);
                        })->pluck('sort_name', 'id');
                        return $board_members;
                        break;
                    case 'Employee':
                        $staff = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_STAFF);
                        })->pluck('sort_name', 'id');
                        return $staff;
                        break;
                    case 'Volunteer':
                        $volunteers = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
                            $query->where('group_id', '=', GROUP_ID_VOLUNTEER);
                        })->pluck('sort_name', 'id');
                        return $volunteers;
                        break;
                    
                    //default null
                    default:
                        $individuals = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name', 'asc')->pluck('sort_name', 'id');
                        return $individuals;
                        break;
                }
        }
    }
}
