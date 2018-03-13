<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $preserveGlobalState = false;
    protected $runTestInSeparateProcess = true;

    //setup and teardown functions
    
    public function testBasicTest()
    {
        // $response = $this->get('/home');
        $this->assertTrue(true);
    }
}
