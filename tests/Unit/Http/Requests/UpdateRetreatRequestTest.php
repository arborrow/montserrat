<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Validation\Rule;


/**
 * @see \App\Http\Requests\UpdateRetreatRequest
 */
class UpdateRetreatRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateRetreatRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateRetreatRequest();
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
    {   $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');
        // TODO: not sure how best to handle the $this-id in the idnumber - should probably explore using something else, for now mark is incomplete and skip the test

        $actual = $this->subject->rules();

        $this->assertEquals([
          'idnumber' => 'required|unique:event,idnumber,'.$this->id,
          'start_date' => 'required|date|before:end_date',
          'end_date' => 'required|date|after:start_date',
          'title' => 'required',
          'innkeeper_id' => 'integer|min:0',
          'assistant_id' => 'integer|min:0',
          'year' => 'integer|min:1990|max:2020',
          'amount' => 'numeric|min:0|max:100000',
          'attending' => 'integer|min:0|max:150',
          'silent' => 'boolean',
          'is_active' => 'boolean',
          'contract' => 'file|mimes:pdf|max:5000|nullable',
          'schedule' => 'file|mimes:pdf|max:5000|nullable',
          'evaluations' => 'file|mimes:pdf|max:10000|nullable',
          'group_photo' => 'image|max:10000|nullable',
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