<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaymentController
 */
class PaymentControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-payment');
        $donation = \App\Models\Donation::factory()->create();

        $response = $this->actingAs($user)->get('payment/create/'.$donation->donation_id);

        $response->assertOk();
        $response->assertViewIs('payments.create');
        $response->assertViewHas('donation');
        $response->assertViewHas('payment_methods');
        $response->assertSeeText('Create payment');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-payment');
        $payment = \App\Models\Payment::factory()->create();

        $response = $this->actingAs($user)->delete(route('payment.destroy', [$payment]));
        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\DonationController::class, 'show'], $payment->donation_id));
        $this->assertSoftDeleted($payment);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-payment');
        $payment = \App\Models\Payment::factory()->create();

        $response = $this->actingAs($user)->get(route('payment.edit', [$payment]));

        $response->assertOk();
        $response->assertViewIs('payments.edit');
        $response->assertViewHas('payment');
        $response->assertViewHas('payment_methods');
        $response->assertSeeText('Edit payment');
        // verify default values on the edit blade are correctly set based on data from the database to prevent data loss
        $this->assertTrue($this->findFieldValueInResponseContent('payment_date', $payment->payment_date, 'date', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('payment_amount', $payment->payment_amount, 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('payment_description', $payment->payment_description, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('payment_idnumber', $payment->payment_number, 'number', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('note', $payment->note, 'text', $response->getContent()));
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-payment');
        $payment = \App\Models\Payment::factory()->create();
        $response = $this->actingAs($user)->get(route('payment.index'));

        $response->assertOk();
        $response->assertViewIs('payments.index');
        $response->assertViewHas('payments');
        $response->assertSeeText('Payment Index');
        $payments = $response->viewData('payments');
        $this->assertGreaterThanOrEqual('1', $payments->count());
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-payment');
        $payment = \App\Models\Payment::factory()->create();

        $response = $this->actingAs($user)->get(route('payment.show', [$payment]));

        $response->assertOk();
        $response->assertViewIs('payments.show');
        $response->assertViewHas('payment');
        $response->assertSeeText('Payment Details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-payment');
        $donation = \App\Models\Donation::factory()->create();
        $payment_date = $this->faker->dateTime();
        $payment_amount = $this->faker->randomFloat(2, 0, 100000);
        $response = $this->actingAs($user)->post(route('payment.store'), [
            'donation_id' => $donation->donation_id,
            'payment_date' => $payment_date,
            'payment_amount' => $payment_amount,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\DonationController::class, 'show'], $donation->donation_id));
        $this->assertDatabaseHas('Donations_payment', [
            'donation_id' => $donation->donation_id,
            'payment_date' => $payment_date,
            'payment_amount' => $payment_amount,
        ]);
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentController::class,
            'store',
            \App\Http\Requests\StorePaymentRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-payment');
        $payment = \App\Models\Payment::factory()->create();
        $original_payment_amount = $payment->payment_amount;
        $new_payment_amount = $this->faker->randomFloat(2, 0, 100000);

        $response = $this->actingAs($user)->put(route('payment.update', [$payment]), [
            'payment_amount' => $new_payment_amount,
            'donation_id' => $payment->donation_id,
            'payment_date' => $this->faker->dateTime(),
        ]);
        $updated = \App\Models\Payment::findOrFail($payment->payment_id);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\DonationController::class, 'show'], $payment->donation_id));
        $this->assertEquals($updated->payment_amount, $new_payment_amount);
        $this->assertNotEquals($updated->payment_amount, $original_payment_amount);
    }

    /**
     * @test
     */
    public function update_returns_403_response()
    {
        $user = $this->createUserWithPermission('show-payment');
        $payment = \App\Models\Payment::factory()->create();
        $original_payment_amount = $payment->payment_amount;
        $new_payment_amount = $this->faker->randomFloat(2, 0, 100000);

        $response = $this->actingAs($user)->put(route('payment.update', [$payment]), [
            'payment_amount' => $new_payment_amount,
            'donation_id' => $payment->donation_id,
            'payment_date' => $this->faker->dateTime(),
        ]);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentController::class,
            'update',
            \App\Http\Requests\UpdatePaymentRequest::class
        );
    }

    /**
     * @test
     */
    public function results_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-payment');

        $payment = \App\Models\Payment::factory()->create();

        $response = $this->actingAs($user)->get('payment/results?payment_amount='.$payment->payment_amount);

        $response->assertOk();
        $response->assertViewIs('payments.results');
        $response->assertViewHas('payments');
        $response->assertSeeText('result(s) found');
        $response->assertSeeText($payment->payment_amount);
    }

    /**
     * @test
     */
    public function search_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-payment');

        $response = $this->actingAs($user)->get('payment/search');

        $response->assertOk();
        $response->assertViewIs('payments.search');
        $response->assertViewHas('payment_methods');
        $response->assertSeeText('Search Payments');
    }

    // test cases...
}
