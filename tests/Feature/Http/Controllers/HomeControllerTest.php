<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 */
class HomeControllerTest extends TestCase
{
    // use DatabaseTransactions;
    /**
     * @test
     */
    public function goodbye_returns_an_ok_response()
    {
        $response = $this->get('goodbye');

        $response->assertOk();
        $response->assertViewIs('pages.goodbye');
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
    }

    // test cases...
}
