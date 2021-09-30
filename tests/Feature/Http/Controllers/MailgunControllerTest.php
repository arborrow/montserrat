<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MailgunController
 */
class MailgunControllerTest extends TestCase
{
    // use DatabaseTransactions;
    /**
     * @test
     */
    public function get_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('admin-mailgun');
        if (null !== config('services.mailgun.domain') && null !== config('services.mailgun.secret')) {
            $response = $this->actingAs($user)->get(route('mailgun.get'));
            $response->assertOk();
            $response->assertViewIs('mailgun.index');
            $response->assertViewHas('messages');
            $response->assertSee('Mailgun Stored Messages');
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
    public function process_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('admin-mailgun');
        if (null !== config('services.mailgun.domain') && null !== config('services.mailgun.secret')) {
            $response = $this->actingAs($user)->get(route('mailgun.process'));
            $response->assertOk();
            $response->assertViewIs('mailgun.processed');
            $response->assertViewHas('messages');
            $response->assertSee('Index of Mailgun Processed Messages');
        } else {
            $user = $this->createUserWithPermission('show-admin-menu');
            $response = $this->actingAs($user)->get(route('admin.config.mailgun'));
            $response->assertOk();
            $response->assertViewIs('admin.config.mailgun');
            $response->assertSee('Mailgun configuration');
        }
    }

    // test cases...
}
