<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UnauthenticatedAboutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $preserveGlobalState = false;

    protected $runTestInSeparateProcess = true;

    public function testAbout(): void
    {
        // test attempt to see about page without authentication
        $route = route('about');
        $response = $this->get($route);
        $response->assertStatus(302);
    }
}
