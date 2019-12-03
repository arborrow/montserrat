<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedAboutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $preserveGlobalState = false;
    protected $runTestInSeparateProcess = true;

    
    public function testAbout()
    {
         $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
         $abstractUser->shouldReceive('getId')
         ->andReturn(1234567890)
         ->shouldReceive('getEmail')
         ->andReturn(Str::random(10).'@montserratretreat.org')
         ->shouldReceive('getNickname')
         ->andReturn('Pseudo')
         ->shouldReceive('Domain')
         ->andReturn('montserratretreat.org')
         ->shouldReceive('getName')
         ->andReturn('Teresa Tester')
         ->shouldReceive('getAvatar')
         ->andReturn('https://en.gravatar.com/arborrow');

         $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
         $provider->shouldReceive('user')->andReturn($abstractUser);

         Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

         $response = $this->get(route('login.google_callback'));
        // test attempt to see about page without authentication
        
         $response->assertStatus(302);
    }
}
