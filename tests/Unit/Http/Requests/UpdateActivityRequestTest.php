<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateActivityRequest
 */
class UpdateActivityRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateActivityRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateActivityRequest();
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
          'touched_at' => 'required|date',
          'target_id' => 'required|integer|min:0',
          'assignee_id' => 'required|integer|min:0',
          'creator_id' => 'required|integer|min:0',
          'activity_type_id' => 'required|integer|min:1',
          'status_id' => 'required|integer|min:0',
          'priority_id' => 'required|integer|min:0',
          'medium_id' => 'required|integer|min:1',
          'duration' => 'integer|min:0',
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
