<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function create_returns_an_ok_response(): void
    {   // no creating of audit records - redirect to index page
        $user = $this->createUserWithPermission('create-audit');

        $response = $this->actingAs($user)->get(route('audit.create'));

        $response->assertRedirect(action([\App\Http\Controllers\AuditController::class, 'index']));
        $response->assertSessionHas('flash_notification');
    }

    #[Test]
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-audit');
        $audit = \App\Models\Audit::factory()->create();

        $response = $this->actingAs($user)->delete(route('audit.destroy', [$audit]));

        $response->assertRedirect(action([\App\Http\Controllers\AuditController::class, 'index']));
        $response->assertSessionHas('flash_notification');
    }

    #[Test]
    public function edit_returns_an_ok_response(): void
    {   // no editing of audit records - redirect to index
        $user = $this->createUserWithPermission('update-audit');
        $audit = \App\Models\Audit::factory()->create();

        $response = $this->actingAs($user)->get(route('audit.edit', [$audit]));

        $response->assertRedirect(action([\App\Http\Controllers\AuditController::class, 'index']));
        $response->assertSessionHas('flash_notification');
    }

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-audit');

        $response = $this->actingAs($user)->get(route('audit.index'));

        $response->assertOk();
        $response->assertViewIs('admin.audits.index');
        $response->assertViewHas('audits');
        $response->assertViewHas('users');
        $response->assertSeeText('Audits');
    }

    #[Test]
    public function index_type_returns_an_ok_response(): void
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

    #[Test]
    public function results_returns_an_ok_response(): void
    {
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('show-audit');

        $audit = \App\Models\Audit::factory()->create();
        $response = $this->actingAs($user)->get('admin/audit/results?url='.$audit->url);

        $response->assertOk();
        $response->assertViewIs('admin.audits.results');
        $response->assertViewHas('audits');
        $response->assertSeeText('result(s) found');
        $response->assertSeeText($audit->url);
    }

    #[Test]
    public function search_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-audit');

        $response = $this->actingAs($user)->get('admin/audit/search');

        $response->assertOk();
        $response->assertViewIs('admin.audits.search');
        $response->assertViewHas('users');
        $response->assertViewHas('models');
        $response->assertViewHas('actions');
        $response->assertSeeText('Search Audit Logs');
    }

    #[Test]
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-audit');
        $audit = \App\Models\Audit::factory()->create();

        $response = $this->actingAs($user)->get(route('audit.show', [$audit]));

        $response->assertOk();
        $response->assertViewIs('admin.audits.show');
        $response->assertViewHas('audit');
        $response->assertSeeText('Audit details');
    }

    #[Test]
    public function store_returns_an_ok_response(): void
    {   // no storing of audit records - redirect to audit.index
        // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-audit');

        $response = $this->actingAs($user)->post(route('audit.store'), [
            'ip_address' => $this->faker->ipv4(),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\AuditController::class, 'index']));
        $response->assertSessionHas('flash_notification');
    }

    #[Test]
    public function update_returns_an_ok_response(): void
    {   // no updating of audit records - redirect to audit.index
        $user = $this->createUserWithPermission('update-audit');
        $audit = \App\Models\Audit::factory()->create();

        $response = $this->actingAs($user)->put(route('audit.update', [$audit]), [
            'ip_address' => $this->faker->ipv4(),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\AuditController::class, 'index']));
        $response->assertSessionHas('flash_notification');
    }

    // test cases...
}
