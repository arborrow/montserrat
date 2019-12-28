<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreRetreatRequest
 */
class StoreRetreatRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreRetreatRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreRetreatRequest();
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
          'idnumber' => 'required|unique:event,idnumber',
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
