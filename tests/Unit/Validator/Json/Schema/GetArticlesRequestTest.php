<?php declare(strict_types=1);

namespace PeeHaa\FeedMeTest\Unit\Validator\Json\Schema;

use HarmonyIO\Validation\Result\Result;
use PeeHaa\FeedMe\Validator\Request\GetArticles;
use PHPUnit\Framework\TestCase;
use function Amp\Promise\wait;

class GetArticlesRequestTest extends TestCase
{
    /** @var array<mixed> */
    private $validRequestData;

    public function setUp(): void
    {
        $this->validRequestData = [
            'id'   => 'd776156a-fcad-409d-aaea-b9fda317b25c',
            'type' => 'GetArticles',
            'data' => (object) [],
        ];
    }

    public function testValidateFailsOnMissingId(): void
    {
        unset($this->validRequestData['id']);

        /** @var Result $result */
        $result = wait((new GetArticles())->validate(json_encode($this->validRequestData)));

        $this->assertFalse($result->isValid());
    }

    public function testValidateFailsOnMissingType(): void
    {
        unset($this->validRequestData['type']);

        /** @var Result $result */
        $result = wait((new GetArticles())->validate(json_encode($this->validRequestData)));

        $this->assertFalse($result->isValid());
    }

    public function testValidateFailsOnMissingData(): void
    {
        unset($this->validRequestData['data']);

        /** @var Result $result */
        $result = wait((new GetArticles())->validate(json_encode($this->validRequestData)));

        $this->assertFalse($result->isValid());
    }

    public function testValidateSucceedsOnValidRequest(): void
    {
        /** @var Result $result */
        $result = wait((new GetArticles())->validate(json_encode($this->validRequestData)));

        $this->assertTrue($result->isValid());
    }
}
