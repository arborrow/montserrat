<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AuditController
 */
class AuditControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {   // no creating of audit records - redirect to index page
        $user = $this->createUserWithPermission('create-audit');

        $response = $this->actingAs($user)->get(route('audit.create'));

        $response->assertRedirect(action('AuditController@index'));
        $response->assertSessionHas('flash_notification');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('delete-audit');
        $audit = \App\Models\Audit::factory()->create();

        $response = $this->actingAs($user)->delete(route('audit.destroy', [$audit]));

        $response->assertRedirect(action('AuditController@index'));
        $response->assertSessionHas('flash_notification');
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {   // no editing of audit records - redirect to index
        $user = $this->createUserWithPermission('update-audit');
        $audit = \App\Models\Audit::factory()->create();

        $response = $this->actingAs($user)->get(route('audit.edit', [$audit]));

        $response->assertRedirect(action('AuditController@index'));
        $response->assertSessionHas('flash_notification');
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-audit');

        $response = $this->actingAs($user)->get(route('audit.index'));

        $response->assertOk();
        $response->assertViewIs('admin.audits.index');
        $response->assertViewHas('audits');
        $response->assertViewHas('users');
        $response->assertSeeText('Audits');
    }

    /**
     * @test
     */
    public function index_type_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-audit');
        $audit = \App\Models\Audit::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('admin/audit/user/'.$user->id);
        $results = $response->viewData('audits');
        $response->assertOk();
        $response->assertViewIs('admin.audits.index');
        $response->assertViewHas('audits');
        $response->assertViewHas('users');
        $response->assertSeeText('Audits');
        $response->assertSeeText($audit->user_name);
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $user = $this->createUserWithPermission('show-audit');
        $audit = \App\Models\Audit::factory()->create();

        $response = $this->actingAs($user)->get(route('audit.show', [$audit]));

        $response->assertOk();
        $response->assertViewIs('admin.audits.show');
        $response->assertViewHas('audit');
        $response->assertSeeText('Audit details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {   // no storing of audit records - redirect to audit.index
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-audit');

        $response = $this->actingAs($user)->post(route('audit.store'), [
            'ip_address' => $this->faker->ipv4,
        ]);

        $response->assertRedirect(action('AuditController@index'));
        $response->assertSessionHas('flash_notification');
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {   // no updating of audit records - redirect to audit.index
        $user = $this->createUserWithPermission('update-audit');
        $audit = \App\Models\Audit::factory()->create();

        $response = $this->actingAs($user)->put(route('audit.update', [$audit]), [
            'ip_address' => $this->faker->ipv4,
        ]);

        $response->assertRedirect(action('AuditController@index'));
        $response->assertSessionHas('flash_notification');
    }

    // test cases...
}
