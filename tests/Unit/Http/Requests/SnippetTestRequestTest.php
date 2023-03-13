<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateDonationRequest
 */
class SnippetTestRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateSnippetRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\SnippetTestRequest();
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
            'title' => 'string|required',
            'language' => 'string|required',
            'email' => 'email|required',
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
