<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new \GuzzleHttp\Client();
        $result = $client->get('http://labs.bible.org/api/?passage=random')->getBody();
        $quote = strip_tags($result->getContents(),'<b>');
         
//        $quote = 'Jesus loves me this I know';
        return view('home', compact('quote'));
    }
    public function goodbye()
    {
        return view('pages.goodbye');
    }
}
