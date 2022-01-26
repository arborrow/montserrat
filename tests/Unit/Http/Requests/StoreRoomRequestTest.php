<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreRoomRequest
 */
class StoreRoomRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreRoomRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreRoomRequest();
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
            'name' => 'required',
            'location_id' => 'integer|required|min:0',
            'floor' => 'integer|min:0',
            'occupancy' => 'integer|min:0',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'access' => 'string|nullable',
            'type' => 'string|nullable',
            'status' => 'string|nullable',
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
}
