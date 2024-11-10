<?php

namespace Tests\Unit\Http\Requests;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Requests\AddmeRelationshipTypeRequest
 */
final class AddmeRelationshipTypeRequestTest extends TestCase
{
    /** @var \App\Http\Requests\AddmeRelationshipTypeRequest */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = new \App\Http\Requests\AddmeRelationshipTypeRequest;
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
            'relationship_type_name' => 'required|in:Child,Parent,Husband,Wife,Sibling,Employee,Volunteer,Parishioner,Primary contact,Employer,Diocese,Parish,Deacon,Priest,Board member',
            'contact_id' => 'integer|min:1|required',
            'relationship_filter_alternate_name' => 'string|nullable',
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
