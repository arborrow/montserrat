<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreUomRequest
 */
final class StoreDepartmentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreLocationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreDepartmentRequest;
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
            'name' => 'string|required',
            'label' => 'string|nullable',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'parent_id' => 'integer|nullable',
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
