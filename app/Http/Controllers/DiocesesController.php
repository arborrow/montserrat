<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

class DiocesesController extends Controller
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
        // need to implement getting Bishop's name from bishop_id
        $dioceses = \montserrat\Diocese::orderBy('name', 'asc')->get();
        return view('dioceses.index',compact('dioceses'));   //
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$bishops = \montserrat\Bishop::orderby('lastname')->lists('lastname','id');
        $bishops = array();
        $bishops[0]='Not implemented yet';
        return view('dioceses.create',compact('dioceses','bishops'));  
    
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
                'bishop_id' => 'integer|min:0',
                'email' => 'email',
                'webpage' => 'url'
            ]);
        $diocese = new \montserrat\Diocese;
        $diocese->bishop_id= $request->input('bishop_id');
        $diocese->name = $request->input('name');
        $diocese->address1 = $request->input('address1');
        $diocese->address2 = $request->input('address2');
        $diocese->city = $request->input('city');
        $diocese->state = $request->input('state');
        $diocese->zip = $request->input('zip');
        $diocese->phone= $request->input('phone');
        $diocese->fax = $request->input('fax');
        $diocese->email = $request->input('email');
        $diocese->webpage = $request->input('webpage');
        $diocese->notes = $request->input('notes');
        $diocese->save();
return Redirect::action('DiocesesController@index');
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
        $diocese = \montserrat\Diocese::find($id);
        // $diocese =  \montserrat\Diocese::find($id)->bishop;
        $diocese->bishop = 'Bishop name lookup not yet implemented';
        
       return view('dioceses.show',compact('diocese'));//
    
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
        $bishops = array();
        $bishops[0] = "Not yet implemented";
        $diocese = \montserrat\Diocese::findOrFail($id);
      
       return view('dioceses.edit',compact('diocese','bishops'));
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
            'bishop_id' => 'integer|min:0',
            'email' => 'email',
            'webpage' => 'url'
        ]);

        $diocese = \montserrat\Diocese::findOrFail($request->input('id'));
        $diocese->bishop_id= $request->input('bishop_id');
        $diocese->name = $request->input('name');
        $diocese->address1 = $request->input('address1');
        $diocese->address2 = $request->input('address2');
        $diocese->city = $request->input('city');
        $diocese->state = $request->input('state');
        $diocese->zip = $request->input('zip');
        $diocese->phone= $request->input('phone');
        $diocese->fax = $request->input('fax');
        $diocese->email = $request->input('email');
        $diocese->webpage = $request->input('webpage');
        $diocese->notes = $request->input('notes');
        $diocese->save();

        return Redirect::action('DiocesesController@index');
        
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
         \montserrat\Diocese::destroy($id);
        return Redirect::action('DiocesesController@index');
    }
}
