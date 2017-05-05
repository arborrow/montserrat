<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Response;

class HomeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        // $this->action('GET', 'HomeController@index');
        // $this->assertResponseOk();
        $route = route('home');
        $response = $this->get($route)->assertSee('Welcome to Polanco');
        $response->assertStatus(200);
        
    }
}
