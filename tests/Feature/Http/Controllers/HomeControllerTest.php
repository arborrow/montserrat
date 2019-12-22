<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 */
class HomeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function goodbye_returns_an_ok_response()
    {

        $response = $this->get('goodbye');

        $response->assertOk();
        $response->assertViewIs('pages.goodbye');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('home');
        $response->assertSee('Welcome to Polanco');
        $response->assertViewHas('quote');

        // TODO: perform additional assertions
    }

    // test cases...
}
