<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VendorController
 */
class VendorControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    #[Test]
    public function create_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-contact');

        $response = $this->actingAs($user)->get(route('vendor.create'));

        $response->assertOk();
        $response->assertViewIs('vendors.create');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertSeeText('Add a Vendor');
    }

    #[Test]
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-contact');
        $vendor = \App\Models\Vendor::factory()->create();

        $response = $this->actingAs($user)->delete(route('vendor.destroy', ['vendor' => $vendor]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\VendorController::class, 'index']));
        $this->assertSoftDeleted($vendor);
    }

    #[Test]
    public function edit_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-contact');
        $vendor = \App\Models\Vendor::factory()->create();
        $vendor = \App\Models\Contact::findOrFail($vendor->id);
        $vendor_note = \App\Models\Note::factory()->create([
            'entity_table' => 'contact',
            'entity_id' => $vendor->id,
            'subject' => 'Vendor note',
        ]);

        $main_address = \App\Models\Address::factory()->create([
            'contact_id' => $vendor->id,
            'location_type_id' => config('polanco.location_type.main'),
            'is_primary' => 1,
        ]);

        $main_phone = \App\Models\Phone::factory()->create([
            'contact_id' => $vendor->id,
            'location_type_id' => config('polanco.location_type.main'),
            'is_primary' => 1,
            'phone_type' => 'Phone',
        ]);

        $main_fax = \App\Models\Phone::factory()->create([
            'contact_id' => $vendor->id,
            'location_type_id' => config('polanco.location_type.main'),
            'phone_type' => 'Fax',
        ]);

        $main_email = \App\Models\Email::factory()->create([
            'contact_id' => $vendor->id,
            'is_primary' => 1,
            'location_type_id' => config('polanco.location_type.main'),
        ]);

        $url_main = \App\Models\Website::factory()->create([
            'contact_id' => $vendor->id,
            'website_type' => 'Main',
            'url' => $this->faker->url(),
        ]);
        $url_work = \App\Models\Website::factory()->create([
            'contact_id' => $vendor->id,
            'website_type' => 'Work',
            'url' => $this->faker->url(),
        ]);
        $url_facebook = \App\Models\Website::factory()->create([
            'contact_id' => $vendor->id,
            'website_type' => 'Facebook',
            'url' => 'https://facebook.com/'.$this->faker->slug(),
        ]);
        $url_instagram = \App\Models\Website::factory()->create([
            'contact_id' => $vendor->id,
            'website_type' => 'Instagram',
            'url' => 'https://instagram.com/'.$this->faker->slug(),
        ]);
        $url_linkedin = \App\Models\Website::factory()->create([
            'contact_id' => $vendor->id,
            'website_type' => 'LinkedIn',
            'url' => 'https://linkedin.com/'.$this->faker->slug(),
        ]);
        $url_twitter = \App\Models\Website::factory()->create([
            'contact_id' => $vendor->id,
            'website_type' => 'Twitter',
            'url' => 'https://twitter.com/'.$this->faker->slug(),
        ]);

        $response = $this->actingAs($user)->get(route('vendor.edit', $vendor->id));
        $response->assertOk();
        $response->assertViewIs('vendors.edit');
        $response->assertViewHas('vendor');
        $response->assertViewHas('states');
        $response->assertViewHas('countries');
        $response->assertViewHas('defaults');
        $response->assertSeeText($vendor->organization_name);

        $this->assertTrue($this->findFieldValueInResponseContent('organization_name', $vendor->organization_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('display_name', $vendor->display_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('sort_name', $vendor->sort_name, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('street_address', $vendor->address_primary_street, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('supplemental_address_1', $vendor->address_primary_supplemental_address, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('city', $vendor->address_primary_city, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('state_province_id', $vendor->address_primary_state_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('postal_code', $vendor->address_primary_postal_code, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('country_id', $vendor->address_primary_country_id, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_phone', $vendor->phone_main_phone_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('phone_main_fax', $vendor->phone_main_fax_number, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('email_primary', $vendor->email_primary_text, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('note_vendor', $vendor->note_vendor_text, 'textarea', $response->getContent()));
        // urls
        $this->assertTrue($this->findFieldValueInResponseContent('url_main', $url_main->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_work', $url_work->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_facebook', $url_facebook->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_instagram', $url_instagram->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_linkedin', $url_linkedin->url, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('url_twitter', $url_twitter->url, 'text', $response->getContent()));
    }

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-contact');
        $vendor = \App\Models\Vendor::factory()->create();

        $response = $this->actingAs($user)->get(route('vendor.index'));

        $vendors = $response->viewData('vendors');

        $response->assertOk();
        $response->assertViewIs('vendors.index');
        $response->assertViewHas('vendors');
        $response->assertSeeText('Vendors');
        $this->assertGreaterThanOrEqual('1', $vendors->count());
    }

    #[Test]
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-contact');
        $vendor = \App\Models\Vendor::factory()->create();

        $response = $this->actingAs($user)->get(route('vendor.show', ['vendor' => $vendor]));

        $response->assertOk();
        $response->assertViewIs('vendors.show');
        $response->assertViewHas('vendor');
        $response->assertViewHas('relationship_filter_types');
        $response->assertViewHas('files');
        $response->assertSeeText($vendor->display_name);
    }

    #[Test]
    public function store_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-contact');
        $vendor_name = $this->faker->company();

        $response = $this->actingAs($user)->post(route('vendor.store'), [
            'organization_name' => $vendor_name,
            'display_name' => $vendor_name,
            'sort_name' => $vendor_name,
            'contact_type' => config('polanco.contact_type.organization'),
            'subcontact_type' => config('polanco.contact_type.vendor'),
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\VendorController::class, 'index']));

        $this->assertDatabaseHas('contact', [
            'contact_type' => config('polanco.contact_type.organization'),
            'subcontact_type' => config('polanco.contact_type.vendor'),
            'sort_name' => $vendor_name,
            'display_name' => $vendor_name,
            'organization_name' => $vendor_name,
        ]);
    }

    #[Test]
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VendorController::class,
            'store',
            \App\Http\Requests\StoreVendorRequest::class
        );
    }

    #[Test]
    public function update_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-contact');
        $vendor = \App\Models\Vendor::factory()->create();
        $original_sort_name = $vendor->sort_name;
        $vendor_name = $this->faker->company();

        $response = $this->actingAs($user)->put(route('vendor.update', $vendor), [
            'sort_name' => $vendor_name,
            'display_name' => $vendor_name,
            'organization_name' => $vendor_name,
            'id' => $vendor->id,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\VendorController::class, 'show'], $vendor->id));

        $updated = \App\Models\Contact::find($vendor->id);

        $response->assertRedirect(action([\App\Http\Controllers\VendorController::class, 'show'], $vendor->id));
        $this->assertEquals($updated->sort_name, $vendor_name);
        $this->assertNotEquals($updated->sort_name, $original_sort_name);
    }

    #[Test]
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VendorController::class,
            'update',
            \App\Http\Requests\UpdateVendorRequest::class
        );
    }

    // test cases...
}
