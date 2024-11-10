<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 */
final class HomeControllerTest extends TestCase
{
    // use DatabaseTransactions;
    #[Test]
    public function goodbye_returns_an_ok_response(): void
    {
        $response = $this->get('goodbye');

        $response->assertOk();
        $response->assertViewIs('pages.goodbye');
    }

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('home');
        $response->assertSee('Welcome to Polanco');
        $response->assertViewHas('quote');
    }

    // test cases...
}
