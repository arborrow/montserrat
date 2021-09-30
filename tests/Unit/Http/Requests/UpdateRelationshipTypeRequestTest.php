<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateRelationshipTypeRequest
 */
class UpdateRelationshipTypeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateRelationshipTypeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateRelationshipTypeRequest();
    }

    /**
     * @test
     */
    public function authorize()
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function rules()
    {
        $actual = $this->subject->rules();

        $this->assertEquals([
          'description' => 'required',
          'name_a_b' => 'required',
          'label_a_b' => 'required',
          'name_b_a' => 'required',
          'label_b_a' => 'required',
          'is_active' => 'integer|min:0|max:1',
          'is_reserved' => 'integer|min:0|max:1',
        ], $actual);
    }

    /**
     * @test
     */
    public function messages()
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
