<?php declare(strict_types=1);

namespace PeeHaa\FeedMe\Validator\Request\GetArticles;

use Amp\Promise;
use HarmonyIO\Validation\Result\Result;
use HarmonyIO\Validation\Rule\Rule;
use PeeHaa\FeedMe\Validator\Text\ExactMatch;

final class Type implements Rule
{
    /**
     * @param mixed $value
     * @return Promise<Result>
     */
    public function validate($value): Promise
    {
        return (new ExactMatch('GetArticles'))->validate($value['type']);
    }
}
