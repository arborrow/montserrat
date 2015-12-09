<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;

use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

class ParishesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parishes = \montserrat\Parish::orderBy('name', 'asc')->get();
         foreach ($parishes as $parish) {
            $parish->diocese = \montserrat\Diocese::find($parish->diocese_id)->name;
        }
        $parishes = $parishes->sortBy(function($parish) {
            return sprintf('%-12s%s',$parish->diocese,$parish->name);
        }); 
        return view('parishes.index',compact('parishes'));   //
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dioceses = \montserrat\Diocese::orderby('name')->lists('name','id');
        //$pastors = \montserrat\Pastor::orderby('lastname')->lists('lastname','id');
        $pastors = array();
        $pastors[0]='Not implemented yet';
        return view('parishes.create',compact('dioceses','pastors'));  
    
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
                'name' => 'required',
                'diocese_id' => 'integer|min:0',
                'pastor_id' => 'integer|min:0',
                'email' => 'email',
                'webpage' => 'url'
            ]);
        $parish = new \montserrat\Parish;
        $parish->diocese_id = $request->input('diocese_id');
        $parish->pastor_id= $request->input('pastor_id');
        $parish->name = $request->input('name');
        $parish->address1 = $request->input('address1');
        $parish->address2 = $request->input('address2');
        $parish->city = $request->input('city');
        $parish->state = $request->input('state');
        $parish->zip = $request->input('zip');
        $parish->phone= $request->input('phone');
        $parish->fax = $request->input('fax');
        $parish->email = $request->input('email');
        $parish->webpage = $request->input('webpage');
        $parish->notes = $request->input('notes');
        $parish->save();
return Redirect::action('ParishesController@index');
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
        $parish = \montserrat\Parish::findOrFail($id);
        $diocese =  \montserrat\Parish::find($id)->diocese;
        $parish->diocese = $diocese->name;
        $parishioners = \montserrat\Retreatant::where('parish_id',$id)->orderBy('lastname')->get();
        //dd($parishioners);
       return view('parishes.show',compact('parish','parishioners'));//
    
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
        $dioceses = \montserrat\Diocese::orderby('name')->lists('name','id');
        $pastors = array();
        $pastors[0] = "Not yet implemented";
        $parish = \montserrat\Parish::findOrFail($id);
      
       return view('parishes.edit',compact('parish','dioceses','pastors'));
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
            'name' => 'required',
            'diocese_id' => 'integer|min:0',
            'pastor_id' => 'integer|min:0',
            'email' => 'email',
            'webpage' => 'url'
        ]);

        $parish = \montserrat\Parish::findOrFail($request->input('id'));
        $parish->diocese_id = $request->input('diocese_id');
        $parish->pastor_id= $request->input('pastor_id');
        $parish->name = $request->input('name');
        $parish->address1 = $request->input('address1');
        $parish->address2 = $request->input('address2');
        $parish->city = $request->input('city');
        $parish->state = $request->input('state');
        $parish->zip = $request->input('zip');
        $parish->phone= $request->input('phone');
        $parish->fax = $request->input('fax');
        $parish->email = $request->input('email');
        $parish->webpage = $request->input('webpage');
        $parish->notes = $request->input('notes');
        $parish->save();

        return Redirect::action('ParishesController@index');
        
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
         \montserrat\Parish::destroy($id);
        return Redirect::action('ParishesController@index');
    }
}
