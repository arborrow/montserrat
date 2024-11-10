<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreUomRequest
 */
class StoreLocationRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreLocationRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreLocationRequest;
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
