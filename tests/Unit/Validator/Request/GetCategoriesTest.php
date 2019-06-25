<?php declare(strict_types=1);

namespace PeeHaa\FeedMeTest\Unit\Validator\Request;

use HarmonyIO\Validation\Result\Result;
use PeeHaa\FeedMe\Validator\Request\GetCategories;
use PHPUnit\Framework\TestCase;
use function Amp\Promise\wait;

class GetCategoriesTest extends TestCase
{
    /** @var array<mixed> */
    private $validRequestData;

    public function setUp(): void
    {
        $this->validRequestData = [
            'id'   => 'e77290ea-d29e-4582-9670-03afdb4bf0e7',
            'type' => 'GetCategories',
            'data' => (object) [],
        ];
    }

    public function testValidateReturnsFailureOnInvalidJson(): void
    {
        /** @var Result $result */
        $result = wait((new GetCategories())->validate('{"foo":'));

        $this->assertFalse($result->isValid());
    }

    public function testValidateReturnsFailureOnInvalidJsonSchema(): void
    {
        /** @var Result $result */
        $result = wait((new GetCategories())->validate('{"foo": "bar"}'));

        $this->assertFalse($result->isValid());
    }

    public function testValidateReturnsFailureOnInvalidId(): void
    {
        unset($this->validRequestData['id']);

        /** @var Result $result */
        $result = wait((new GetCategories())->validate(json_encode($this->validRequestData)));

        $this->assertFalse($result->isValid());
    }

    public function testValidateReturnsFailureOnInvalidType(): void
    {
        unset($this->validRequestData['type']);

        /** @var Result $result */
        $result = wait((new GetCategories())->validate(json_encode($this->validRequestData)));

        $this->assertFalse($result->isValid());
    }

    public function testValidateReturnsSuccessOnValidRequest(): void
    {
        /** @var Result $result */
        $result = wait((new GetCategories())->validate(json_encode($this->validRequestData)));

        $this->assertTrue($result->isValid());
    }
}
