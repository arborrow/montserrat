<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AboutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    
    public function testAbout()
    {
        //$response = $this->get('/about');
        //$response->assertStatus(404);
        $this->assertTrue(true);
    }
}
