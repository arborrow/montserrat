<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateGroupRequest
 */
class UpdateGroupRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateGroupRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateGroupRequest();
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
          'title' => 'required',
          'is_active' => 'integer|min:0|max:1',
          'is_hidden' => 'integer|min:0|max:1',
          'is_reserved' => 'integer|min:0|max:1',
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
