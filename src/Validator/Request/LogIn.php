<?php declare(strict_types=1);

namespace PeeHaa\FeedMe\Validator\Request;

use Amp\Promise;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Combinator\All;
use HarmonyIO\Validation\Rule\DataFormat\Json;
use HarmonyIO\Validation\Rule\Rule;
use PeeHaa\FeedMe\Validator\Combinator\Grouped;
use PeeHaa\FeedMe\Validator\Json\Schema\LogInRequest;
use PeeHaa\FeedMe\Validator\Request\LogIn\Id;
use PeeHaa\FeedMe\Validator\Request\LogIn\Password;
use PeeHaa\FeedMe\Validator\Request\LogIn\Type;
use PeeHaa\FeedMe\Validator\Request\LogIn\Username;
use function Amp\call;

final class LogIn implements Rule
{
    /**
     * @param mixed $value
     * @return Promise<Result>
     */
    public function validate($value): Promise
    {
        return call(static function () use ($value) {
            /** @var Result $result */
            $result = yield (new All(
                new Json(),
                new LogInRequest(),
            ))->validate($value);

            if (!$result->isValid()) {
                return $result;
            }

            $data = json_decode($value, true);

            return (new Grouped([
                'id'       => new Id(),
                'type'     => new Type(),
                'username' => new Username(),
                'password' => new Password(),
            ]))->validate($data);
        });
    }
}
