<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
final class UpdateLocationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateLocationRequest * */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateLocationRequest;
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
            'type' => 'in:'.implode(',', config('polanco.locations_type')).'|required',
            'description' => 'string|nullable',
            'occupancy' => 'integer|nullable',
            'notes' => 'string|nullable',
            'label' => 'string|nullable',
            'latitude' => 'numeric|between:-90,90|nullable',
            'longitude' => 'numeric|between:-180,180|nullable',
            'room_id' => 'integer|nullable',
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
