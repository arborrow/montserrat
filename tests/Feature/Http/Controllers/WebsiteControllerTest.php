<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\WebsiteController
 */
class WebsiteControllerTest extends TestCase
{
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('create-website');

        $response = $this->actingAs($user)->get(route('website.create'));

        $response->assertOk();
        $response->assertViewIs('admin.websites.create');
        $response->assertSeeText('Create website');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-website');
        $website = factory(\App\Website::class)->create();

        $response = $this->actingAs($user)->delete(route('website.destroy', [$website]));

        $response->assertRedirect(action('WebsiteController@index'));
        $this->assertSoftDeleted($website);
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-website');
        $website = factory(\App\Website::class)->create();

        $response = $this->actingAs($user)->get(route('website.edit', [$website]));

        $response->assertOk();
        $response->assertViewIs('admin.websites.edit');
        $response->assertViewHas('website');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('contact_id', $website->contact_id, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('asset_id', $website->asset_id, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('description', $website->description, 'textarea', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url', $website->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('website_type', $website->website_type, 'text', $response->getContent()));

    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-website');

        $response = $this->actingAs($user)->get(route('website.index'));

        $response->assertOk();
        $response->assertViewIs('admin.websites.index');
        $response->assertViewHas('websites');
        $response->assertSeeText('Websites');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-website');
        $website = factory(\App\Website::class)->create();

        $response = $this->actingAs($user)->get(route('website.show', [$website]));

        $response->assertOk();
        $response->assertViewIs('admin.websites.show');
        $response->assertViewHas('website');
        $response->assertSeeText('Website details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUserWithPermission('create-website');
        $contact = factory(\App\Contact::class)->create();
        $asset = factory(\App\Asset::class)->create();

        $website_url = $this->faker->url;
        $website_type = $this->faker->randomElement(config('polanco.website_types'));
        $website_description = $this->faker->sentence(7, true);

        $response = $this->actingAs($user)->post(route('website.store'), [
            'contact_id' => $contact->id,
            'asset_id' => $asset->id,
            'description' => $website_description,
            'website_type' => $website_type,
            'url' => $website_url,
        ]);

        $response->assertRedirect(action('WebsiteController@index'));

        $this->assertDatabaseHas('website', [
            'asset_id' => $asset->id,
            'contact_id' => $contact->id,
            'description' => $website_description,
            'website_type' => $website_type,
            'url' => $website_url,
        ]);
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('update-website');

        $website = factory(\App\Website::class)->create();
        $website_type = $this->faker->randomElement(config('polanco.website_types'));

        $original_website_description = $website->description;
        $new_website_description = 'New ' . $this->faker->sentence;

        $response = $this->actingAs($user)->put(route('website.update', [$website]), [
          'id' => $website->id,
          'asset_id' => $website->asset_id,
          'contact_id' => $website->contact_id,
          'description' => $new_website_description,
          'website_type' => $website_type,
          'url' => $website->url,
        ]);
        $response->assertRedirect(action('WebsiteController@show',$website->id));

        $updated = \App\Website::findOrFail($website->id);

        $this->assertEquals($updated->description, $new_website_description);
        $this->assertNotEquals($updated->description, $original_website_description);

    }

    // test cases...
}
