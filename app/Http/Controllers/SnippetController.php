<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;

use App\Http\Requests\StoreSnippetRequest;
use App\Http\Requests\UpdateSnippetRequest;
use App\Http\Requests\SnippetTestRequest;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Faker;
use App\Mail\RetreatantBirthday;
use App\Mail\RetreatConfirmation;
use Auth;

class SnippetController extends Controller
{

    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('show-snippet');

        $titles = \App\Snippet::groupBy('label')->orderBy('label')->pluck('title', 'title');
        $snippets = \App\Snippet::orderBy('title')->orderBy('locale')->orderBy('label')->get();

        return view('admin.snippets.index', compact('snippets','titles'));
    }

    public function index_type($title = null)
    {
        $this->authorize('show-snippet');

        $titles = \App\Snippet::groupBy('label')->orderBy('label')->pluck('title', 'title');
        $snippets = \App\Snippet::whereTitle($title)->orderBy('title')->orderBy('locale')->orderBy('label')->get();

        return view('admin.snippets.index', compact('snippets', 'titles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-snippet');
        $locales = \App\Language::whereIsActive(1)->orderBy('label')->pluck('label','name');

        return view('admin.snippets.create',compact('locales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSnippetRequest $request)
    {
        $this->authorize('create-snippet');

        $snippet = new \App\Snippet;
        $snippet->title = $request->input('title');
        $snippet->label = $request->input('label');
        $snippet->locale = $request->input('locale');
        $snippet->snippet = $request->input('snippet');

        $snippet->save();

        return Redirect::action('SnippetController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-snippet');

        $snippet = \App\Snippet::findOrFail($id);

        return view('admin.snippets.show', compact('snippet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-snippet');

        $snippet = \App\Snippet::findOrFail($id);
        $locales = \App\Language::whereIsActive(1)->orderBy('label')->pluck('label','name');

        return view('admin.snippets.edit', compact('snippet', 'locales')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSnippetRequest $request, $id)
    {
        $this->authorize('update-snippet');

        $snippet = \App\Snippet::findOrFail($id);

        $snippet->title = $request->input('title');
        $snippet->label = $request->input('label');
        $snippet->locale = $request->input('locale');
        $snippet->snippet = $request->input('snippet');

        $snippet->save();

        return Redirect::action('SnippetController@show', $snippet->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-snippet');

        \App\Snippet::destroy($id);

        return Redirect::action('SnippetController@index');
    }

    public function snippet_test(SnippetTestRequest $request)
    {
        $this->authorize('show-snippet');

        $title = $request->input('title');
        $email = $request->input('email');
        $language = $request->input('language');

        $faker = Faker\Factory::create();
        if (empty($email)) {
            $email = config('polanco.admin_email');
        }

        switch ($title) {
            case "birthday" :
                // dd($title,$email,$language);
                // generate and store snippets
                $snippets = \App\Snippet::whereTitle('birthday')->get();
                foreach ($snippets as $snippet) {
                    $decoded = html_entity_decode($snippet->snippet,ENT_QUOTES | ENT_XML1);
                    Storage::put('views/snippets/'.$snippet->title.'/'.$snippet->locale.'/'.$snippet->label.'.blade.php',$decoded);
                }
                // create fake person
                $receiver = collect();
                $receiver->id = $faker->numberBetween(100,900);
                $receiver->first_name = $faker->firstName;
                $receiver->nick_name = $faker->firstName;
                $receiver->display_name = $receiver->first_name . ' ' . $faker->lastName;
                $receiver->birth_date = $faker->date;
                $receiver->email = $faker->safeEmail;
                $receiver->preferred_language = $language;
                if (!empty($email)) {
                    try {
                        Mail::to($email)->queue(new RetreatantBirthday($receiver));
                        flash ('Birthday test email successfully sent to: '.$email)->success();
                    } catch (\Exception $e) {
                        // dd($e);
                        flash ('Sending of birthday test email to: '.$email.' failed')->error();
                    }
                }
                break;

            case "agc_acknowledge" :
                // not needed - can test via UI by viewing an AGC letter
                $msg = 'AGC acknowledgment snippets can be tested by viewing an actual letter from the <a href="'. url('/agc') . '">AGC list</a>';
                flash ($msg)->warning();
                break;
            case 'event-confirmation':
                $snippets = \App\Snippet::whereTitle('event-confirmation')->get();
                    foreach ($snippets as $snippet) {
                        $decoded = html_entity_decode($snippet->snippet,ENT_QUOTES | ENT_XML1);
                        Storage::put('views/snippets/'.$snippet->title.'/'.$snippet->locale.'/'.$snippet->label.'.blade.php',$decoded);
                    }
                switch ($language) {
                    case 'es_ES' :
                        $registration = \App\Registration::with('event.event_type','contact')
                            ->whereHas('event', function($q) {
                                $q->whereEventTypeId(config('polanco.event_type.ignatian'));
                            })
                            ->whereHas('contact', function($q) use ($language) {
                                $q->wherePreferredLanguage($language);
                            })
                            ->first();
                        break;
                    default : // en_US
                        $registration = \App\Registration::with('event.event_type','contact')
                            ->whereHas('event', function($q) {
                                $q->whereEventTypeId(config('polanco.event_type.ignatian'));
                            })
                            ->whereHas('contact', function($q) {
                                $q->wherePreferredLanguage('en_US');
                            })
                            ->first();

                }
                if (!empty($email)) {
                    try {
                        Mail::to($email)->queue(new RetreatConfirmation($registration));
                        flash ('Retreat confirmation test email successfully sent to: '.$email)->success();
                    } catch (\Exception $e) {
                        // dd($e);
                        flash ('Sending of retreat confirmation test email to: '.$email.' failed')->error();
                    }
                }
                break;
            default :
                flash ('Unknown snippet test: ' . $title)->error();
                break;
        }
        return Redirect::action('SnippetController@index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test($title = null, $email = null, $language="en_US")
    {
        $this->authorize('show-snippet');
        $titles = \App\Snippet::groupBy('label')->orderBy('label')->pluck('title', 'title');
        $languages = \App\Language::whereIsActive(1)->orderBy('label')->pluck('label','name');
        if (empty($email)) {
            $email = Auth::user()->email;
        }
        return view('admin.snippets.test',compact('language','email','title','titles','languages'));
    }

}
