<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GateController
 */
class GateControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    // TODO: develop funcitonal tests
    // for now, I am not actually going to test the functionality but just ensure the controller methods function

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-gate');

        $response = $this->actingAs($user)->get(route('gate.index'));

        $response->assertOk();
        $response->assertViewIs('gate.index');
        $response->assertViewHas('touchpoints');
        $response->assertSeeText('Gate activity');
    }

    #[Test]
    public function close_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-gate');
        $email = \App\Models\Email::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->actingAs($user)->get(route('gate.close'));
        $response->assertOk();
        $response->assertViewIs('gate.close');
        $response->assertViewHas('message');
        $response->assertSeeText('CLOSE');
    }

    #[Test]
    public function open_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-gate');
        $email = \App\Models\Email::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->actingAs($user)->get(route('gate.open'));
        $response->assertOk();
        $response->assertViewIs('gate.open');
        $response->assertViewHas('hours');
        $response->assertViewHas('message');
        $response->assertSeeText('OPEN');
    }

    #[Test]
    public function open_with_hours_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-gate');
        $hours = $this->faker->numberBetween(2, 5);
        $email = \App\Models\Email::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->actingAs($user)->get(route('gate.open'), ['hours' => $hours]);
        $response->assertOk();
        $response->assertViewIs('gate.open');
        $response->assertViewHas('hours');
        $response->assertViewHas('message');
        $response->assertSeeText('OPEN');
        $response->assertSeeText($hours.' hours');
    }

    // test cases...
}
