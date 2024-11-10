<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\SearchRequest
 */
final class AuditSearchRequestTest extends TestCase
{
    /** @var \App\Http\Requests\AuditSearchRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\AuditSearchRequest;
    }

    #[Test]
    public function authorize(): void
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    #[Test]
    public function rules(): void
    {
        $actual = $this->subject->rules();

        $this->assertEquals([
            'created_at_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'created_at' => 'datetime|nullable',
            'user_id' => 'integer|nullable',
            'auditable_id' => 'integer|nullable',
            'event' => 'string|nullable',
            'auditable_type' => 'string|nullable',
            'old_values' => 'string|nullable',
            'new_values' => 'string|nullable',
            'url' => 'string|nullable',
            'tags' => 'string|nullable',
        ], $actual);
    }

    #[Test]
    public function messages(): void
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
