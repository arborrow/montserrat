<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;
use Image;


class RetreatsController extends Controller
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
        //dd(Auth::User());
        $retreats = \montserrat\Retreat::whereDate('end_date', '>=', date('Y-m-d'))->orderBy('start_date','asc')->with('retreatmasters','innkeeper','assistant')->get();
        $oldretreats = \montserrat\Retreat::whereDate('end_date', '<', date('Y-m-d'))->orderBy('start_date','desc')->with('retreatmasters','innkeeper','assistant')->paginate(100);
        // $events = Event::get();
        // dd($events[4]);
        //dd($oldretreats);    
        return view('retreats.index',compact('retreats','oldretreats'));   //
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $retreat_house = \montserrat\Contact::with('retreat_directors.contact_b','retreat_innkeepers.contact_b','retreat_assistants.contact_b','retreat_captains.contact_b')->findOrFail(CONTACT_MONTSERRAT);
        $event_types = \montserrat\EventType::whereIsActive(1)->orderBy('name')->pluck('name','id');
        foreach ($retreat_house->retreat_innkeepers as $innkeeper) {
            $i[$innkeeper->contact_id_b]=$innkeeper->contact_b->sort_name;
        }
        asort($i);
        $i=array(0=>'N/A')+$i;
        
        foreach ($retreat_house->retreat_directors as $director) {
            $d[$director->contact_id_b]=$director->contact_b->sort_name;
        }
        asort($d);
        $d=array(0=>'N/A')+$d;
        
        foreach ($retreat_house->retreat_assistants as $assistant) {
            $a[$assistant->contact_id_b]=$assistant->contact_b->sort_name;
        }
        asort($a);
        $a=array(0=>'N/A')+$a;
        
        foreach ($retreat_house->retreat_captains as $captain) {
            $c[$captain->contact_id_b]=$captain->contact_b->sort_name;
        }
        asort($c);
        $c=array(0=>'N/A')+$c;
        //dd($retreat_house);
        return view('retreats.create',compact('d','i','a','c','event_types'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { // dd($request);
        $this->validate($request, [
            'idnumber' => 'required|unique:retreats',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'title' => 'required',
            'innkeeper_id' => 'integer|min:0',
            'assistant_id' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean'
          ]);
        
        $retreat = new \montserrat\Retreat;
        $retreat->idnumber = $request->input('idnumber');
        $retreat->start_date = $request->input('start_date');
        $retreat->end_date = $request->input('end_date');
        $retreat->title = $request->input('title');
        $retreat->description = $request->input('description');
        // TODO: create dropdown list of retreat types - disable for now
        $retreat->event_type_id = $request->input('event_type');
        // TODO: find a way to tag silent retreats, perhaps with event_type_id - for now disabled
        //$retreat->silent = $request->input('silent');
        // amount will be related to default_fee_id?
        //$retreat->amount = $request->input('amount');
        // attending should be calculated based on retreat participants
        // TODO: consider making Directors, Innkeepers, and Assistants participant roles and adding them by default to retreats
        //$retreat->attending = $request->input('attending');
        //$retreat->year = $request->input('year');
        $retreat->innkeeper_id = $request->input('innkeeper_id');
        $retreat->assistant_id = $request->input('assistant_id');
        $retreat->save();
        if (empty($request->input('directors')) or in_array(0,$request->input('directors'))) {
            $retreat->retreatmasters()->detach();
        } else {
            $retreat->retreatmasters()->sync($request->input('directors'));
        }
        
        if (empty($request->input('captains')) or in_array(0,$request->input('captains'))) {
            $retreat->captains()->detach();
        } else {
            $retreat->captains()->sync($request->input('captains'));
        }
        
        return Redirect::action('RetreatsController@index');//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $retreat = \montserrat\Retreat::with('retreatmasters','innkeeper','assistant','captains')->findOrFail($id);
        $registrations = \montserrat\Registration::where('event_id','=',$id)->with('retreatant.parish')->orderBy('register_date','DESC')->get();
        return view('retreats.show',compact('retreat','registrations'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function edit($id)
    //{
    //   $retreats = \montserrat\Retreat::();
    //   return view('retreats.edit',compact('retreats'));
    //  }
public function edit($id)
    {
        //get this retreat's information
        $retreat = \montserrat\Retreat::with('retreatmasters','assistant','innkeeper','captains')->findOrFail($id);
        $event_types = \montserrat\EventType::whereIsActive(1)->orderBy('name')->pluck('name','id');
        
        //create lists of retreat directors, innkeepers, and assistants from relationship to retreat house 
        $retreat_house = \montserrat\Contact::with('retreat_directors.contact_b','retreat_innkeepers.contact_b','retreat_assistants.contact_b')->findOrFail(CONTACT_MONTSERRAT);
        
        foreach ($retreat_house->retreat_innkeepers as $innkeeper) {
            $i[$innkeeper->contact_id_b]=$innkeeper->contact_b->sort_name;
        }
        asort($i);
        $i=array(0=>'N/A')+$i;
        
        foreach ($retreat_house->retreat_directors as $director) {
            $d[$director->contact_id_b]=$director->contact_b->sort_name;
        }
        asort($d);
        $d=array(0=>'N/A')+$d;
        
        foreach ($retreat_house->retreat_assistants as $assistant) {
            $a[$assistant->contact_id_b]=$assistant->contact_b->sort_name;
        }
        asort($a);
        $a=array(0=>'N/A')+$a;
        
        foreach ($retreat_house->retreat_captains as $captain) {
            $c[$captain->contact_id_b]=$captain->contact_b->sort_name;
        }
        asort($c);
        $c=array(0=>'N/A')+$c;
      
       //dd($a);
       return view('retreats.edit',compact('retreat','d','i','a','c','event_types'));
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
      // dd($request);
        $this->validate($request, [
            'idnumber' => 'required|unique:retreats,idnumber,'.$id,
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'title' => 'required',
            'innkeeper_id' => 'integer|min:0',
            'assistant_id' => 'integer|min:0',
            'year' => 'integer|min:1990|max:2020',
            'amount' => 'numeric|min:0|max:100000',
            'attending' => 'integer|min:0|max:150',
            'silent' => 'boolean',
            'contract' => 'file|mimes:pdf|max:5000',
            'schedule' => 'file|mimes:pdf|max:5000',
            'evaluations' => 'file|mimes:pdf|max:10000',
            'photo' => 'image|max:10000',
            
        ]);
        
        $retreat = \montserrat\Retreat::findOrFail($request->input('id'));
        $retreat->idnumber = $request->input('idnumber');
        $retreat->start_date = $request->input('start_date');
        $retreat->end_date = $request->input('end_date');
        $retreat->title = $request->input('title');
        $retreat->description = $request->input('description');
        $retreat->event_type_id = $request->input('event_type');
        //TODO: Figure out how to use event type or some other way of tracking the silent retreats, possibly silent boolean field in event table
        //$retreat->silent = $request->input('silent');
        //$retreat->amount = $request->input('amount');
        // attending field not needed - will calculate with count on registrations
        //$retreat->attending = $request->input('attending');
        //$retreat->year = $request->input('year');
        $retreat->innkeeper_id = $request->input('innkeeper_id');
        $retreat->assistant_id = $request->input('assistant_id');
        $retreat->save();

        if (null !== $request->file('contract')) {
            $contract = new \montserrat\Attachment;
            $file = $request->file('contract');
            $file_name = $file->getClientOriginalName();
            $contract->file_type_id = FILE_TYPE_EVENT_CONTRACT;
            $contract->mime_type = $file->getClientMimeType();
            $contract->uri = 'contract.pdf';
            $contract->description = 'Contract for '.$retreat->idnumber.'-'.$retreat->title;
            $contract->upload_date = \Carbon\Carbon::now();
            $contract->entity = "event";
            $contract->entity_id = $retreat->id;
            $contract->save();
            Storage::disk('local')->put('events/'.$retreat->id.'/contract.pdf',File::get($file));
        }
        
        if (null !== $request->file('schedule')) {
            $schedule = new \montserrat\Attachment;
            $file = $request->file('schedule');
            $file_name = $file->getClientOriginalName();
            $schedule->file_type_id = FILE_TYPE_EVENT_SCHEDULE;
            $schedule->mime_type = $file->getClientMimeType();
            $schedule->uri = 'schedule.pdf';
            $schedule->description = 'Schedule for '.$retreat->idnumber.'-'.$retreat->title;
            $schedule->upload_date = \Carbon\Carbon::now();
            $schedule->entity = "event";
            $schedule->entity_id = $retreat->id;
            $schedule->save();
            Storage::disk('local')->put('events/'.$retreat->id.'/schedule.pdf',File::get($file));
        }
        if (null !== $request->file('evaluations')) {
            $evaluations = new \montserrat\Attachment;
            $file = $request->file('evaluations');
            $file_name = $file->getClientOriginalName();
            
            $evaluations->file_type_id = FILE_TYPE_EVENT_EVALUATION;
            $evaluations->mime_type = $file->getClientMimeType();
            $evaluations->uri = 'evaluations.pdf';
            $evaluations->description = 'Evaluations for '.$retreat->idnumber.'-'.$retreat->title;
            $evaluations->upload_date = \Carbon\Carbon::now();
            $evaluations->entity = "event";
            $evaluations->entity_id = $retreat->id;
            $evaluations->save();
            Storage::disk('local')->put('events/'.$retreat->id.'/evaluations.pdf',File::get($file));
        }
        
        if (null !== $request->file('photo')) {
            $group_photo = Image::make($request->file('photo')->getRealPath());
            Storage::put('events/'.$retreat->id.'/'.'group_photo.jpg',$group_photo->stream('jpg'));
                $evaluations = new \montserrat\Attachment;
            $file = $request->file('photo');
            $file_name = 'group_photo.jpg';
            
            $evaluations->file_type_id = FILE_TYPE_EVENT_GROUP_PHOTO;
            $evaluations->mime_type = $file->getClientMimeType();
            $evaluations->uri = 'group_photo.jpg';
            $evaluations->description = 'Group photo for '.$retreat->idnumber.'-'.$retreat->title;
            $evaluations->upload_date = \Carbon\Carbon::now();
            $evaluations->entity = "event";
            $evaluations->entity_id = $retreat->id;
            $evaluations->save();
        }
        
        if (empty($request->input('directors')) or in_array(0,$request->input('directors'))) {
            $retreat->retreatmasters()->detach();
        } else {
            $retreat->retreatmasters()->sync($request->input('directors'));
        }
        if (empty($request->input('captains')) or in_array(0,$request->input('captains'))) {
            $retreat->captains()->detach();
        } else {
            $retreat->captains()->sync($request->input('captains'));
        }
       
        return Redirect::action('RetreatsController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       \montserrat\Retreat::destroy($id);
       return Redirect::action('RetreatsController@index');
       //
    }
 
    public function get_event_contract($event_id) {
        $path = storage_path() . '/app/events/'.$event_id.'/contract.pdf';
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }    

    public function get_event_schedule($event_id) {
        $path = storage_path() . '/app/events/'.$event_id.'/schedule.pdf';
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }    

    
    public function get_event_evaluations($event_id) {
        $path = storage_path() . '/app/events/'.$event_id.'/evaluations.pdf';
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }  

    public function get_event_group_photo($event_id) {
        $path = storage_path() . '/app/events/'.$event_id.'/group_photo.jpg';
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }    

    public function assign_rooms($id)
    {
        //get this retreat's information
        $retreat = \montserrat\Retreat::with('retreatmasters','assistant','innkeeper','captains')->findOrFail($id);
        $registrations = \montserrat\Registration::where('event_id','=',$id)->with('retreatant.parish')->orderBy('register_date','DESC')->get();
        $rooms= \montserrat\Room::orderby('name')->pluck('name','id');
        $rooms->prepend('Unassigned',0);
       
       return view('retreats.assign_rooms',compact('retreat','registrations','rooms'));
      }

public function room_update(Request $request)
    {
        //
       //dd($request);
        $this->validate($request, [
            'retreat_id' => 'integer|min:0',
            
        ]);
        if (null !== $request->input('registrations')) {
            foreach($request->input('registrations') as $key => $value) {

                $registration = \montserrat\Registration::findOrFail($key);
                $registration->room_id = $value;
                $registration->save();
                //dd($registration,$value);
            }
        }
        if (null !== $request->input('notes')) {
            foreach($request->input('notes') as $key => $value) {

                $registration = \montserrat\Registration::findOrFail($key);
                $registration->notes = $value;
                $registration->save();
                //dd($registration,$value);
            }
        }
        return Redirect::action('RetreatsController@index');
    }    
    
}