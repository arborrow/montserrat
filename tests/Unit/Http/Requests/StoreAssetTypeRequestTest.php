<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreAssetTypeRequest
 */
final class StoreAssetTypeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreAssetTypeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreAssetTypeRequest;
    }

    #[Test]
    public function authorize(): void
    {
        $actual = $this->subject->authorize();

        $this->assertTrue($actual);
    }

    #[Test]
    public function rules(): void
    {
        $actual = $this->subject->rules();

        $this->assertEquals([
            'label' => 'string|max:125|required',
            'name' => 'string|max:125|nullable',
            'description' => 'string|nullable',
            'is_active' => 'boolean|nullable',
            'parent_asset_type_id' => 'integer|min:0|nullable',
            'remember_token' => 'string|nullable',
        ], $actual);
    }

    #[Test]
    public function messages(): void
    {
        $actual = $this->subject->messages();

        $this->assertEquals([], $actual);
    }

    // test cases...
}
