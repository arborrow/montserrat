<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\MakeRelationshipTypeRequest
 */
class MakeRelationshipTypeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\MakeRelationshipTypeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\MakeRelationshipTypeRequest;
    }

    /**
     * @test
     */
    public function authorize(): void
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules(): void
    {
        $actual = $this->subject->rules();

        $this->assertEquals([
            'contact_a_id' => 'integer|min:0|required',
            'contact_b_id' => 'integer|min:0|required',
            'relationship_type_id' => 'integer|min:0|required',
            'direction' => 'in:a,b|required',
        ], $actual);
    }

    /**
     * @test
     */
    public function messages(): void
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
