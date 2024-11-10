<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateRoomRequest
 */
final class UpdateRoomRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateRoomRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateRoomRequest;
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
            'location_id' => 'integer|min:0',
            'floor' => 'integer|min:0',
            'occupancy' => 'integer|min:0',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'access' => 'string|nullable',
            'type' => 'string|nullable',
            'status' => 'string|nullable',
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
