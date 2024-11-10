<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
final class UpdateDepartmentRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateDepartmentRequest * */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateDepartmentRequest;
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
            'id' => 'integer|min:1|required',
            'name' => 'string|required',
            'label' => 'string|nullable',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'parent_id' => 'integer|nullable',
            'is_active' => 'boolean|nullable',
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
