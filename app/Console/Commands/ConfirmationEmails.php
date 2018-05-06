<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\RetreatConfirmation;
use Carbon\Carbon;
use App\Retreat;
use Illuminate\Mail\Mailer;

class ConfirmationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:confirmations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send out confirmation emails 1 week in advance for a retreat';

    protected $mailer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $startDate = Carbon::today()->addDays(7);
        $retreats = Retreat::whereDate('start_date', $startDate)
            ->where('event_type_id', 7)
            ->get();

        if ($retreats->count() >= 1) {
            foreach ($retreats as $retreat) {
                $retreatants = $retreat->registrations()
                    ->with('contact')
                    ->whereHas('contact', function($query) {
                        $query->where('do_not_email', 0);
                    })
                    ->get();
                foreach ($retreatants as $retreatant) {
                    $primaryEmail = $retreatant->contact->primaryEmail()->first()->email;    
                    try {
                        $this->mailer->to($primaryEmail)->queue(new RetreatConfirmation($retreatant));
                    } catch ( \Exception $e ) {

                    }
                }
            }
        }
    }
}
