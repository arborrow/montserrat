<?php

namespace App\Console\Commands;

use App\Mail\RetreatConfirmation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Str;

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
        $retreats = \App\Retreat::whereDate('start_date', $startDate)
            ->where('event_type_id', config('polanco.event_type.ignatian'))
            ->whereIsActive(1)
            ->get();

        if ($retreats->count() >= 1) {
            foreach ($retreats as $retreat) {
                $automaticSuccessMessage = 'Automatic confirmation email has been sent for retreat #'.$retreat->idnumber.'.';
                $automaticErrorMessage = 'Automatic confirmation email failed to send for retreat #'.$retreat->idnumber.'.';

                $registrations = $retreat->registrations()
                    ->where('canceled_at', null)
                    ->where('status_id', config('polanco.registration_status_id.registered'))
                    ->with('contact')
                    ->whereHas('contact', function ($query) {
                        $query->where('do_not_email', 0);
                    })
                    ->with('contact.touchpoints')
                    ->whereDoesntHave('contact.touchpoints', function ($query) use ($automaticSuccessMessage) {
                        $query->where('notes', 'like', $automaticSuccessMessage);
                    })
                    ->get();

                foreach ($registrations as $registration) {
                    $primaryEmail = $registration->retreatant->email_primary_text;

                    // For automatic emails, remember_token must be set for all participants in retreat.
                    if (! $registration->remember_token) {
                        $registration->remember_token = Str::random(60);
                        $registration->save();
                    }
                    // TODO: create Juan Alfonso de Polanco contact in seeder; however, if it does not exist use self id from polanco config
                    $alfonso = \App\Contact::where('display_name', 'Juan Alfonso de Polanco')->first();
                    if (! isset($alfonso->id)) {
                        $alfonso = \App\Contact::findOrFail(config('polanco.self.id'));
                    }
                    $touchpoint = new \App\Touchpoint();
                    $touchpoint->person_id = $registration->contact->id;
                    $touchpoint->staff_id = $alfonso->id;
                    $touchpoint->touched_at = Carbon::now();
                    $touchpoint->type = 'Email';

                    try {
                        $this->mailer->to($primaryEmail)->queue(new RetreatConfirmation($registration));
                        $touchpoint->notes = $automaticSuccessMessage;
                        $touchpoint->save();
                    } catch (\Exception $e) {
                        $touchpoint->notes = $automaticErrorMessage;
                        $touchpoint->save();
                    }
                }
            }
        }
    }
}
