<?php

namespace App\Console\Commands;

use App\Mail\PostRetreat;
use App\Models\Retreat;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PostRetreatEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:post-retreat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send out post retreat emails.';

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
    public function handle(): int
    {
        $endDate = Carbon::today()->subDays(1);
        $retreats = Retreat::where('event_type_id', 7)
            ->whereDate('end_date', $endDate)
            ->get();

        if ($retreats->count() >= 1) {
            foreach ($retreats as $retreat) {
                $registrations = $retreat->registrations()
                    ->with('contact')
                    ->whereHas('contact', function ($query) {
                        $query->where('do_not_email', 0);
                    })
                    ->get();

                if ($registrations->count() >= 1) {
                    foreach ($registrations as $registration) {
                        if (null !== $registration->retreatant->primaryEmail()->first()) {
                            $primaryEmail = $registration->retreatant->primaryEmail()->first()->email;
                            try {
                                Mail::to($primaryEmail)->queue(new PostRetreat($retreatant));
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
                // TODO: explore why behavior in test changed during upgrade to Laravel 7
                return 0;
            }
        }
    }
}
