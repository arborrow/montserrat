<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaymentController
 */
class PaymentControllerTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-payment');
        $donation = factory(\App\Donation::class)->create();

        $response = $this->actingAs($user)->get('payment/create/' . $donation->donation_id);

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
        $payment = factory(\App\Payment::class)->create();

        $response = $this->actingAs($user)->delete(route('payment.destroy', [$payment]));

        $response->assertRedirect(action('DonationController@show', $payment->donation_id));
        $this->assertSoftDeleted($payment);

    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-payment');
        $payment = factory(\App\Payment::class)->create();

        $response = $this->actingAs($user)->get(route('payment.edit', [$payment]));

        $response->assertOk();
        $response->assertViewIs('payments.edit');
        $response->assertViewHas('payment');
        $response->assertViewHas('payment_methods');
        $response->assertSeeText('Edit payment');

    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-payment');
        $payment = factory(\App\Payment::class)->create();
        $response = $this->actingAs($user)->get(route('payment.index'));

        $response->assertOk();
        $response->assertViewIs('payments.index');
        $response->assertViewHas('payments');
        $response->assertSeeText('Payment Index');
        $payments = $response->viewData('payments');
        $this->assertGreaterThanOrEqual('1',$payments->count());

    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-payment');
        $payment = factory(\App\Payment::class)->create();

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
        $donation = factory(\App\Donation::class)->create();
        $payment_date = $this->faker->dateTime();
        $payment_amount = $this->faker->randomFloat(2,0,100000);
        $response = $this->actingAs($user)->post(route('payment.store'), [
            'donation_id' => $donation->donation_id,
            'payment_date' => $payment_date,
            'payment_amount' => $payment_amount,
        ]);

        $response->assertRedirect(action('DonationController@show', $donation->donation_id));
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
        $payment = factory(\App\Payment::class)->create();
        $original_payment_amount = $payment->payment_amount;
        $new_payment_amount = $this->faker->randomFloat(2,0,100000);

        $response = $this->actingAs($user)->put(route('payment.update', [$payment]), [
            'payment_amount' => $new_payment_amount,
            'donation_id' => $payment->donation_id,
            'payment_date' => $this->faker->dateTime(),
        ]);
        $updated = \App\Payment::findOrFail($payment->payment_id);

        $response->assertRedirect(action('DonationController@show', $payment->donation_id));
        $this->assertEquals($updated->payment_amount, $new_payment_amount);
        $this->assertNotEquals($updated->payment_amount, $original_payment_amount);

    }

    /**
     * @test
     */
    public function update_returns_403_response()
    {
        $user = $this->createUserWithPermission('show-payment');
        $payment = factory(\App\Payment::class)->create();
        $original_payment_amount = $payment->payment_amount;
        $new_payment_amount = $this->faker->randomFloat(2,0,100000);

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

    // test cases...
}
