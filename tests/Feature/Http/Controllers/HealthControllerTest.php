<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GateController
 */
final class HealthControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    // TODO: develop funcitonal tests
    // for now, I am not actually going to test the functionality but just ensure the controller methods function

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-admin-menu');

        $response = $this->actingAs($user)->get(route('admin.health.index'));

        $response->assertOk();
        $response->assertViewIs('health.index');
        $response->assertViewHas('results');
        $response->assertSeeText('Database Health Checks');
    }

    // test cases...
}
