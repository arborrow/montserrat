<?php

namespace Tests\Unit\Http\Requests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rule;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\UpdateAssetTypeRequest
 */
class UpdateAssetTypeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\UpdateAssetTypeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\UpdateAssetTypeRequest();
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
            'id' => 'integer|min:1|required',
            'label' => 'string|max:125|required',
            'name' => 'string|max:125|nullable',
            'description' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'parent_asset_type_id' => 'integer|min:0|nullable',
            'remember_token' => 'string|nullable',
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
