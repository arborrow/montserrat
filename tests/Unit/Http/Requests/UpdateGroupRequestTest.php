<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateGroupRequest
 */
final class UpdateGroupRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateGroupRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateGroupRequest;
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
            'name' => 'required',
            'title' => 'required',
            'is_active' => 'integer|min:0|max:1',
            'is_hidden' => 'integer|min:0|max:1',
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
