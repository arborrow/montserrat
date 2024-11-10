<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\StoreUomRequest
 */
final class StoreExportListRequestTest extends TestCase
{
    /** @var \App\Http\Requests\StoreExportListRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\StoreExportListRequest;
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
            'title' => 'string|max:125|required',
            'label' => 'string|max:125|required',
            'type' => 'in:'.implode(',', config('polanco.export_list_types')).'|required',
            'fields' => 'string|nullable',
            'filters' => 'string|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'next_scheduled_date' => 'date|nullable',
            'last_run_date' => 'date|nullable',
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
