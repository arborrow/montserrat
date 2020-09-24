<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rule;
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
            'donation_date_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_amount_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'start_date_only_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'end_date_only_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_install_operator' => 'in:'.implode(',', config('polanco.operators')).'|nullable',
            'donation_date' => 'date|nullable',
            'start_date_only' => 'date|nullable',
            'end_date_only' => 'date|nullable',
            'donation_description' => 'string|nullable',
            'event_id' => 'integer|nullable',
            'donation_amount' => 'numeric|nullable',
            'donation_install' => 'numeric|nullable',
            'notes' => 'string|nullable',
            'terms' => 'string|nullable',
            'donation_thank_you' => 'string|nullable',
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
