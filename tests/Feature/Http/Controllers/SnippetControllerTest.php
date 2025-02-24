<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SnippetController
 */
final class SnippetControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use withFaker;

    #[Test]
    public function create_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('create-snippet');

        $response = $this->actingAs($user)->get(route('snippet.create'));

        $response->assertOk();
        $response->assertViewIs('admin.snippets.create');
        $response->assertSeeText('Create snippet');
        $response->assertViewHas('locales');
    }

    #[Test]
    public function destroy_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('delete-snippet');
        $snippet = \App\Models\Snippet::factory()->create();

        $response = $this->actingAs($user)->delete(route('snippet.destroy', [$snippet]));

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SnippetController::class, 'index']));
        $this->assertSoftDeleted($snippet);
    }

    #[Test]
    public function edit_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-snippet');
        $snippet = \App\Models\Snippet::factory()->create();

        $response = $this->actingAs($user)->get(route('snippet.edit', [$snippet]));

        $response->assertOk();
        $response->assertViewIs('admin.snippets.edit');
        $response->assertViewHas('snippet');
        $response->assertViewHas('locales');
        $response->assertSeeText('Edit');

        $this->assertTrue($this->findFieldValueInResponseContent('title', $snippet->title, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('label', $snippet->label, 'text', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('locale', $snippet->locale, 'select', $response->getContent()));
        $this->assertTrue($this->findFieldValueInResponseContent('snippet', $snippet->snippet, 'textarea', $response->getContent()));
    }

    #[Test]
    public function index_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-snippet');

        $response = $this->actingAs($user)->get(route('snippet.index'));

        $response->assertOk();
        $response->assertViewIs('admin.snippets.index');
        $response->assertViewHas('snippets');
        $response->assertViewHas('titles');
        $response->assertSeeText('Snippets');
    }

    #[Test]
    public function index_type_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-snippet');

        $snippet = \App\Models\Snippet::factory()->create();

        $number_snippets = $this->faker->numberBetween(2, 5);
        $snippets = \App\Models\Snippet::factory()->count($number_snippets)->create([
            'title' => $snippet->title,
            'deleted_at' => null,
        ]);

        $response = $this->actingAs($user)->get('admin/snippet/title/'.$snippet->title);
        $results = $response->viewData('snippets');
        $response->assertOk();
        $response->assertViewIs('admin.snippets.index');
        $response->assertViewHas('snippets');
        $response->assertViewHas('titles');
        $response->assertSeeText('Snippets');
        $response->assertSeeText($snippet->title);
        $this->assertGreaterThan($number_snippets, $results->count());
    }

    #[Test]
    public function show_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-snippet');
        $snippet = \App\Models\Snippet::factory()->create();

        $response = $this->actingAs($user)->get(route('snippet.show', [$snippet]));

        $response->assertOk();
        $response->assertViewIs('admin.snippets.show');
        $response->assertViewHas('snippet');
        $response->assertSeeText('Snippet details');
    }

    #[Test]
    public function store_returns_an_ok_response(): void
    {   // $this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('create-snippet');

        $title = $this->faker->word();
        $label = $this->faker->word();
        $snippet = $this->faker->sentence(7, true);

        $response = $this->actingAs($user)->post(route('snippet.store'), [
            'title' => $title,
            'label' => $label,
            'locale' => 'en_US',
            'snippet' => $snippet,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SnippetController::class, 'index']));

        $this->assertDatabaseHas('snippets', [
            'title' => $title,
            'snippet' => $snippet,
            'label' => $label,
        ]);
    }

    #[Test]
    public function snippet_test_returns_an_ok_response()
    // this test is a bit of a happy path and a fail path to ensure no emails are sent
    // we begin using a bogus title which should produce a flash session warning that the snippet was not found; however, we still wind up at the index page
    {   //$this->withoutExceptionHandling();
        $user = $this->createUserWithPermission('show-snippet');

        $response = $this->actingAs($user)->post(route('snippet.snippet_test'), [
            'title' => $this->faker->lastName(),
            'language' => $this->faker->locale(),
            'email' => $this->faker->safeEmail(),
        ]);

        $response->assertRedirect(action([\App\Http\Controllers\SnippetController::class, 'index']));
        $response->assertSessionHas('flash_notification');
    }

    #[Test]
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SnippetController::class,
            'store',
            \App\Http\Requests\StoreSnippetRequest::class
        );
    }

    #[Test]
    public function test_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('show-snippet');

        $response = $this->actingAs($user)->get(route('snippet.test'));

        $response->assertOk();
        $response->assertViewIs('admin.snippets.test');
        $response->assertSeeText('Snippet tests');
        $response->assertViewHas('titles');
        $response->assertViewHas('languages');
        $response->assertViewHas('title');
        $response->assertViewHas('email');
        $response->assertViewHas('language');
    }

    #[Test]
    public function test_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SnippetController::class,
            'snippet_test',
            \App\Http\Requests\SnippetTestRequest::class
        );
    }

    #[Test]
    public function update_returns_an_ok_response(): void
    {
        $user = $this->createUserWithPermission('update-snippet');

        $snippet = \App\Models\Snippet::factory()->create();

        $original_title = $snippet->title;
        $new_title = 'New '.$this->faker->words(2, true);

        $response = $this->actingAs($user)->put(route('snippet.update', [$snippet]), [
            'id' => $snippet->id,
            'title' => $new_title,
            'snippet' => $this->faker->sentence(7, true),
            'label' => $snippet->label,
            'locale' => $snippet->locale,
        ]);

        $response->assertSessionHas('flash_notification');
        $response->assertRedirect(action([\App\Http\Controllers\SnippetController::class, 'show'], $snippet->id));

        $updated = \App\Models\Snippet::findOrFail($snippet->id);

        $this->assertEquals($updated->title, $new_title);
        $this->assertNotEquals($updated->title, $original_title);
    }

    #[Test]
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SnippetController::class,
            'update',
            \App\Http\Requests\UpdateSnippetRequest::class
        );
    }

    // test cases...
}
