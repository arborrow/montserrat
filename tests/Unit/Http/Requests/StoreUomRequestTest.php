<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreUomRequest
 */
class StoreUomRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreUomRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreUomRequest();
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
            'type' => 'in:'.implode(',', config('polanco.uom_types')).'|required',
            'unit_name' => 'string|max:125|nullable',
            'unit_symbol' => 'string|max:125|nullable',
            'description' => 'string|nullable',
            'is_active' => 'boolean|nullable',
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
