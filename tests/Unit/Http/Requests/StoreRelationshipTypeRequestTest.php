<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreRelationshipTypeRequest
 */
final class StoreRelationshipTypeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreRelationshipTypeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreRelationshipTypeRequest;
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
            'description' => 'required',
            'name_a_b' => 'required',
            'label_a_b' => 'required',
            'name_b_a' => 'required',
            'label_b_a' => 'required',
            'contact_type_a' => 'required',
            'contact_type_b' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_reserved' => 'integer|min:0|max:1',
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
