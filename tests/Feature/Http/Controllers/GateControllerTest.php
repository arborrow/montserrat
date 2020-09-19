<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GateController
 */
class GateControllerTest extends TestCase
{   // TODO: develop funcitonal tests
    // for now, I am not actually going to test the functionality but just ensure the controller methods function

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-gate');

        $response = $this->actingAs($user)->get(route('gate.index'));

        $response->assertOk();
        $response->assertViewIs('gate.index');
        $response->assertViewHas('touchpoints');
        $response->assertSeeText('Gate activity');
    }

    /**
     * @test
     */
    public function close_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-gate');
        $email = factory(\App\Models\Email::class)->create([
            'email' => $user->email,
        ]);

        $response = $this->actingAs($user)->get(route('gate.close'));
        $response->assertOk();
        $response->assertViewIs('gate.close');
        $response->assertViewHas('message');
        $response->assertSeeText('CLOSE');
    }

    /**
     * @test
     */
    public function open_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-gate');
        $email = factory(\App\Models\Email::class)->create([
            'email' => $user->email,
        ]);

        $response = $this->actingAs($user)->get(route('gate.open'));
        $response->assertOk();
        $response->assertViewIs('gate.open');
        $response->assertViewHas('hours');
        $response->assertViewHas('message');
        $response->assertSeeText('OPEN');
    }

    // test cases...
}
