<?php

namespace App\Console\Commands;

use App\Contact;
use Illuminate\Console\Command;
use App\Mail\RetreatantBirthday;

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
    public function handle()
    {
        $receivers = new Contact;
	$receivers = $receivers->birthdayEmailReceivers();
	// dd($receivers);
        foreach ($receivers as $key => $receiver) {
            try {
                \Mail::to($receiver->email)->queue(new RetreatantBirthday($receiver));
            } catch (\Exception $e) {
                // don't do anything
            }
        }
    }
}
