<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreUomRequest
 */
class StoreDepartmentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreLocationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreDepartmentRequest();
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
            'name' => 'string|required',
            'label' => 'string|nullable',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'parent_id' => 'integer|nullable',
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
