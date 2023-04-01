<?php

namespace App\Console\Commands;

use App\Mail\RetreatantBirthday;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendBirthdays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:birthdays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out birthday emails to retreatants with birthdays of current day.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {   // get list of contacts whose birthday is today - they are the birthday email recipients or receivers
        $receivers = new Contact;
        $receivers = $receivers->birthdayEmailReceivers();
        // get and store birthday snippets
        $snippets = \App\Models\Snippet::whereTitle('birthday')->get();
        foreach ($snippets as $snippet) {
            $decoded = html_entity_decode($snippet->snippet, ENT_QUOTES | ENT_XML1);
            Storage::put('views/snippets/'.$snippet->title.'/'.$snippet->locale.'/'.$snippet->label.'.blade.php', $decoded);
        }
        // prepare touchpoint by getting Polanco's contact.id
        // TODO: create Juan Alfonso de Polanco contact in seeder; however, if it does not exist use self id from polanco config
        $alfonso = \App\Models\Contact::where('display_name', 'Juan Alfonso de Polanco')->first();
        if (! isset($alfonso->id)) {
            $alfonso = \App\Models\Contact::findOrFail(config('polanco.self.id'));
        }
        // for each receiver create a touchpoint and if able to send an email document success otherwise document failed email
        foreach ($receivers as $key => $receiver) {
            $touchpoint = new \App\Models\Touchpoint();
            $touchpoint->person_id = $receiver->id;
            $touchpoint->staff_id = $alfonso->id;
            $touchpoint->touched_at = Carbon::now();
            $touchpoint->type = 'Email';

            try {
                Mail::to($receiver->email)->queue(new RetreatantBirthday($receiver));
                $touchpoint->notes = 'Automatic birthday email has been sent.';
                $touchpoint->save();
            } catch (\Exception $e) {
                $touchpoint->notes = 'Automatic birthday email failed to send: '.$e->getMessage();
                $touchpoint->save();
            }
        }
    }
}
