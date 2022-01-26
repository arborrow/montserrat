<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DonationController
 */
class DonationControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function agc_returns_an_ok_response()
    {   // agc reports available from 2007 to 2020
        $user = $this->createUserWithPermission('show-donation');
        $year = $this->faker->numberBetween(2007, 2020);
        $response = $this->actingAs($user)->get('agc/'.$year);

        $response->assertOk();
        $response->assertViewIs('donations.agc');
        $response->assertViewHas('donations');
        $response->assertViewHas('total');
    }

    /**
     * @test
     */
    public function agc_returns_404()
    {
        $user = $this->createUserWithPermission('show-donation');
        $year = $this->faker->numberBetween(2000, 2005);
        $response = $this->actingAs($user)->get('agc/'.$year);

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-donation');
        $response = $this->actingAs($user)->get(route('donation.create'));

        $response->assertOk();
        $response->assertViewIs('donations.create');
        $response->assertViewHas('retreats');
        $response->assertViewHas('donors');
        $response->assertViewHas('descriptions');
        $response->assertViewHas('payment_methods');
        $response->assertViewHas('defaults');
    }

    /**
     * @test
     */
    public function create_with_contact_id_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-donation');
        $contact = \App\Models\Contact::factory()->create();

        $response = $this->actingAs($user)->get('donation/add/'.$contact->id);

        $response->assertOk();
        $response->assertViewIs('donations.create');
        $response->assertViewHas('retreats');
        $response->assertViewHas('donors', function ($donors) use ($contact) {
            return $donors->contains($contact->sort_name);
        });
        $response->assertViewHas('descriptions');
        $response->assertViewHas('payment_methods');
        $response->assertViewHas('defaults');
    }

    /**
     * @test
     */
    public function create_with_event_id_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-donation');
        $contact = \App\Models\Contact::factory()->create();
        $event = \App\Models\Retreat::factory()->create();

        $response = $this->actingAs($user)->get('donation/add/'.$contact->id.'/'.$event->id);

        $response->assertOk();
        $response->assertViewIs('donations.create');

        $response->assertViewHas('retreats', function ($events) use ($event) {
            return $events->has($event->id);
        });

        $response->assertViewHas('donors', function ($donors) use ($contact) {
            return $donors->has($contact->id);
        });
        $response->assertViewHas('descriptions');
        $response->assertViewHas('payment_methods');
        $response->assertViewHas('defaults');
    }

    /**
     * @test
     */
    public function create_with_type_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-donation');
        $type = array_rand(config('polanco.contact_type'));
        $contact = \App\Models\Contact::factory()->create([
            'subcontact_type' => config('polanco.contact_type.'.$type),
        ]);
        $event = \App\Models\Retreat::factory()->create();

        $response = $this->actingAs($user)->get('donation/add/'.$contact->id.'/'.$event->id.'/'.$type);

        $response->assertOk();
        $response->assertViewIs('donations.create');

        $response->assertViewHas('retreats', function ($events) use ($event) {
            return $events->has($event->id);
        });

        $response->assertViewHas('donors', function ($donors) use ($contact) {
            return $donors->has($contact->id);
        });
        $response->assertViewHas('descriptions');
        $response->assertViewHas('payment_methods');
        $response->assertViewHas('defaults');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-donation');
        $donation = \App\Models\Donation::factory()->create();
        $contact = \App\Models\Contact::find($donation->contact_id);

        $response = $this->actingAs($user)->delete(route('donation.destroy', [$donation]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect($contact->contact_url);

        $this->assertSoftDeleted($donation);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-donation');
        $donation = \App\Models\Donation::factory()->create();

        $response = $this->actingAs($user)->get(route('donation.edit', [$donation]));

        $response->assertOk();
        $response->assertViewIs('donations.edit');
        $response->assertViewHas('donation');
        $response->assertViewHas('descriptions');
        $response->assertViewHas('defaults');
        $response->assertViewHas('retreats');

        $this->assertTrue($this->findFieldValueInResponseContent('donation_description', $donation->donation_description, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('event_id', $donation->event_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('donation_date', $donation->donation_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('donation_amount', $donation->donation_amount, 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('notes1', $donation->Notes1, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('notes', $donation->Notes, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('terms', $donation->terms, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('start_date', $donation->start_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('end_date', $donation->end_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('donation_install', $donation->donation_install, 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('donation_thank_you', $donation->donation_thank_you_sent, 'select', $response->getContent()));
        // TODO: clean up Donation.thank_you field so that it only contains Y or N and consider switching to boolean field
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donation');

        $response = $this->actingAs($user)->get(route('donation.index'));

        $response->assertOk();
        $response->assertViewIs('donations.index');
        $response->assertViewHas('donations');
    }

    /**
     * @test
     */
    public function index_type_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donation');
        // create a new event type, add a random number of retreats (2-10) to that event type ensuring they are all future events
        $donation = \App\Models\Donation::factory()->create();
        $donation_id = $donation->donation_id;
        $number_donations = $this->faker->numberBetween(2, 10);
        $donations = \App\Models\Donation::factory()->count($number_donations)->create([
            'donation_description' => $donation->donation_description,
            'deleted_at' => null,
        ]);

        $response = $this->actingAs($user)->get('donation/type/'.$donation_id);
        $results = $response->viewData('donations');
        $response->assertOk();
        $response->assertViewIs('donations.index');
        $response->assertViewHas('donations');
        $response->assertViewHas('donation_descriptions');
        $response->assertSeeText($donation->donation_description);
        $this->assertGreaterThan($number_donations, $results->count());
    }

    /**
     * @test
     */
    public function overpaid_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donation');
        $response = $this->actingAs($user)->get('donation/overpaid');

        $response->assertOk();
        $response->assertViewIs('donations.overpaid');
        $response->assertViewHas('overpaid');
    }

    /**
     * @test
     */
    public function retreat_payments_update_returns_an_ok_response()
    {   // create a retreat with 1-10 participants
        // update retreatant payments
        $user = $this->createUserWithPermission('update-donation');

        $retreat = \App\Models\Retreat::factory()->create([
            'description' => 'Retreat Payments Update Test',
        ]);
        $participants = \App\Models\Registration::factory()->count($this->faker->numberBetween(5, 10))->create([
            'event_id' => $retreat->id,
            'canceled_at' => null,
        ]);
        $donations = [];

        $participants = \App\Models\Registration::whereEventId($retreat->id)->get();
        foreach ($participants as $participant) {
            $donations[$participant->id]['id'] = $participant->id;
            $donations[$participant->id]['pledge'] = $this->faker->numberBetween(100, 200);
            $donations[$participant->id]['paid'] = $this->faker->numberBetween(100, 200);
            $donations[$participant->id]['method'] = 'Credit Card';
            $donations[$participant->id]['idnumber'] = $this->faker->randomNumber(6);
            $donations[$participant->id]['terms'] = $this->faker->sentence;
        }
        $random_participant = $participants->random();

        $response = $this->actingAs($user)->post(route('retreat.payments.update'), [
            'event_id' => $retreat->id,
            'donations' => $donations,
        ]);
        $response->assertRedirect(action('RetreatController@show', $retreat->id));
        $this->assertDatabaseHas('Donations', [
            'event_id' => $retreat->id,
            'contact_id' => $random_participant->contact_id,
        ]);
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donation');
        // create a payment rather than just a donation so that things like percent_paid
        $payment = \App\Models\Payment::factory()->create();

        $response = $this->actingAs($user)->get(route('donation.show', [$payment->donation_id]));
        $response->assertOk();
        $response->assertViewIs('donations.show');
        $response->assertViewHas('donation');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-donation');
        $donor = \App\Models\Contact::factory()->create();
        $event = \App\Models\Retreat::factory()->create();
        $start_date = $this->faker->dateTimeBetween('this week', '+7 days');

        $response = $this->actingAs($user)->post(route('donation.store'), [
            'donor_id' => $donor->id,
            'event_id' => $event->id,
            'donation_date' => $this->faker->dateTime(),
            'payment_date' => $this->faker->dateTime(),
            'donation_amount' => $this->faker->randomFloat(2, 0, 100000),
            'payment_amount' => $this->faker->randomFloat(2, 0, 100000),
            'payment_idnumber' => $this->faker->randomNumber(4),
            'donation_install' => $this->faker->randomFloat(2, 0, 100000),
            // TODO: figure out and clean up start and end dates - commenting out for now
            // 'start_date_only' => $start_date_only,
            // 'end_date_only' => $this->faker->dateTimeBetween($start_date_only, strtotime('+7 days')),

        ]);
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect($donor->contact_url.'#donations');
        $this->assertDatabaseHas('Donations', [
            'contact_id' => $donor->id,
            'event_id' => $event->id,
        ]);
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DonationController::class,
            'store',
            \App\Http\Requests\StoreDonationRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('update-donation');
        $event = \App\Models\Retreat::factory()->create();
        $donation = \App\Models\Donation::factory()->create();
        $new_contact = \App\Models\Contact::factory()->create();
        $description = \App\Models\DonationType::get()->random();
        $start_date = $this->faker->dateTimeBetween('this week', '+7 days');
        $end_date = $this->faker->dateTimeBetween($start_date, strtotime('+7 days'));

        $original_amount = $donation->donation_amount;
        $response = $this->actingAs($user)->put(route('donation.update', [$donation]), [
            'donation_description' => $description->id,
            'donor_id' => $new_contact->id,
            'event_id' => $event->id,
            'donation_date' => $this->faker->dateTime,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'donation_amount' => $this->faker->randomFloat(2, 0, 100000),
            'notes1' => $this->faker->text,
            'notes' => $this->faker->text,
            'terms' => $this->faker->text,
            'donation_install' => $this->faker->randomFloat(2, 0, 100000),
        ]);

        // TODO: remove space on Thank You field in Donation table then add to unit test

        $response->assertRedirect(action('DonationController@show', $donation->donation_id));
        $response->assertSessionHas('flash_notification');

        $updated_donation = \App\Models\Donation::find($donation->donation_id);
        $this->assertEquals($updated_donation->event_id, $event->id);
        $this->assertNotEquals($updated_donation->donation_amount, $original_amount);
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DonationController::class,
            'update',
            \App\Http\Requests\UpdateDonationRequest::class
        );
    }

    /**
     * @test
     */
    public function results_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donation');

        $donation = \App\Models\Donation::factory()->create();

        $response = $this->actingAs($user)->get('donation/results?donation_amount='.$donation->donation_amount);

        $response->assertOk();
        $response->assertViewIs('donations.results');
        $response->assertViewHas('donations');
        $response->assertSeeText('result(s) found');
        $response->assertSeeText($donation->donation_amount);
    }

    /**
     * @test
     */
    public function search_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-donation');

        $response = $this->actingAs($user)->get('donation/search');

        $response->assertOk();
        $response->assertViewIs('donations.search');
        $response->assertViewHas('descriptions');
        $response->assertViewHas('retreats');
        $response->assertSeeText('Search Donations');
    }

    // test cases...
}
