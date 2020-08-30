<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Exception;


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
        try {
            $result = Http::timeout(1)->get('http://labs.bible.org/api/?passage=random')->getBody();
            $quote = strip_tags($result->getContents(), '<b>');
        } catch (Exception $e) {
                $quote = "John 3:16 - For God so loved the world that he gave his only Son, so that everyone who believes in him might not perish but might have eternal life.";
        }

        return view('home', compact('quote'));
    }

    public function goodbye()
    {
        return view('pages.goodbye');
    }
}
