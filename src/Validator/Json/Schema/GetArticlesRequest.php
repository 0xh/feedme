<?php declare(strict_types=1);

namespace PeeHaa\FeedMe\Validator\Json\Schema;

use Amp\Promise;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use Opis\JsonSchema\Schema;
use Opis\JsonSchema\Validator;
use function HarmonyIO\Validation\fail;
use function HarmonyIO\Validation\succeed;

final class GetArticlesRequest implements Rule
{
    /** @var Schema */
    private $schema;

    public function __construct()
    {
        $this->schema = Schema::fromJsonString(json_encode([
            'id'         => 'https://feedme.pieterhordijk.com/get-articles.request.schema.json',
            'schema'     => 'http://json-schema.org/draft-07/schema#',
            'title'      => 'FeedMe GetArticles Request',
            'type'       => 'object',
            'required'   => [
                'id',
                'type',
                'data',
            ],
            'properties' => [
                'id' => [
                    'type' => 'string',
                ],
                'type' => [
                    'const' => 'GetArticles',
                ],
                'data' => [
                    'type' => 'object',
                ],
            ],
        ], JSON_UNESCAPED_SLASHES));
    }

    /**
     * @param mixed $value
     * @return Promise<Result>
     */
    public function validate($value): Promise
    {
        $result = (new Validator())->schemaValidation(json_decode($value), $this->schema);

        if (!$result->isValid()) {
            return fail('JsonStructure.getArticlesRequest');
        }

        return succeed();
    }
}
