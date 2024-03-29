<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\SearchRequest
 */
class EventSearchRequestTest extends TestCase
{
    /** @var \App\Http\Requests\EventSearchRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\EventSearchRequest();
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
            'begin_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'title' => 'string|nullable',
            'idnumber' => 'string|nullable',
            'event_type_id' => 'integer|nullable',
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
