<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Message;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MailgunController
 */
class MailgunControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * Currently disabled - see comment at line ~281 GetMailgunMessages about need for better factory and seed data
     */
    public function get_returns_an_ok_response()
    {   // $this->withoutExceptionHandling();
        $this->followingRedirects();
        $user = $this->createUserWithPermission('admin-mailgun');
        if (null !== config('services.mailgun.domain') && null !== config('services.mailgun.secret')) {
            $response = $this->actingAs($user)->get(route('mailgun.get'));
            $response->assertOk();
            $response->assertViewIs('mailgun.index');
            $response->assertViewHas('messages');
            $response->assertSee('Index of Mailgun Messages');
        } else {
            $user = $this->createUserWithPermission('show-admin-menu');
            $response = $this->actingAs($user)->get(route('admin.config.mailgun'));
            $response->assertOk();
            $response->assertViewIs('admin.config.mailgun');
            $response->assertSee('Mailgun configuration');
        }
    }

    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    { // emtpy slug redireting to mailgun.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('admin-mailgun');

        $response = $this->actingAs($user)->get(route('mailgun.create'));

        $response->assertOk();
        $response->assertViewIs('mailgun.index');
        $response->assertViewHas('messages');
        $response->assertSee('Index of Mailgun Messages');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {  // empty slug redirecting to mailgun.index
        $this->followingRedirects();
        $user = $this->createUserWithPermission('admin-mailgun');
        $message = Message::factory()->create();

        $response = $this->actingAs($user)->delete(route('mailgun.destroy', [$message]));

        $response->assertOk();
        $response->assertViewIs('mailgun.index');
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response(): void
    {   // emtpy slug redireting to mailgun.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('admin-mailgun');
        $message = Message::factory()->create();

        $response = $this->actingAs($user)->get(route('mailgun.edit', [$message]));

        $response->assertOk();
        $response->assertViewIs('mailgun.index');
        $response->assertViewHas('messages');
        $response->assertSee('Index of Mailgun Messages');
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('admin-mailgun');

        $response = $this->actingAs($user)->get(route('mailgun.index'));

        $response->assertOk();
        $response->assertViewIs('mailgun.index');
        $response->assertViewHas('messages');
        $response->assertSee('Index of Mailgun Messages');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('admin-mailgun');
        $message = Message::factory()->create();

        $response = $this->actingAs($user)->get(route('mailgun.show', [$message]));

        $response->assertOk();
        $response->assertViewIs('mailgun.show');
        $response->assertViewHas('message');
        $response->assertSee('Mailgun Message Details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        // emtpy slug redireting to mailgun.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('admin-mailgun');
        $response = $this->actingAs($user)->post(route('mailgun.store'), [
            'mailgun_id' => $this->faker->uuid(),
        ]);

        $response->assertOk();
        $response->assertViewIs('mailgun.index');
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        // emtpy slug redireting to mailgun.index
        $this->followingRedirects();

        $user = $this->createUserWithPermission('admin-mailgun');
        $message = Message::factory()->create();
        $new_mailgun_id = $this->faker->uuid();

        $response = $this->actingAs($user)->put(route('mailgun.update', [$message]), [
            'mailgun_id' => $new_mailgun_id,
        ]);

        $response->assertOk();
        $response->assertViewIs('mailgun.index');
    }
}
