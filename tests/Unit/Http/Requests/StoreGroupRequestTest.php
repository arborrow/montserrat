<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreGroupRequest
 */
class StoreGroupRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreGroupRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreGroupRequest;
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
            'name' => 'required|unique:group',
            'title' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_hidden' => 'integer|min:0|max:1',
            'is_reserved' => 'integer|min:0|max:1',
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
