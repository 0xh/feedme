<?php declare(strict_types=1);

namespace PeeHaa\FeedMeTest\Unit\Queue;

use Amp\Success;
use Auryn\Injector;
use PeeHaa\FeedMe\Collection\Articles;
use PeeHaa\FeedMe\Entity\Article;
use PeeHaa\FeedMe\Entity\Feed;
use PeeHaa\FeedMe\Event\NewArticleManager;
use PeeHaa\FeedMe\Queue\Worker;
use PeeHaa\FeedMe\Storage\Article\Repository;
use PHPUnit\Framework\TestCase;
use function Amp\Promise\wait;

class WorkerTest extends TestCase
{
    public function testRunStoresNewArticles(): void
    {
        $injector          = $this->createMock(Injector::class);
        $articleRepository = $this->createMock(Repository::class);

        $injector
            ->expects($this->once())
            ->method('execute')
            ->willReturn(new Success(new Articles()))
        ;

        $articleRepository
            ->expects($this->once())
            ->method('storeNewArticles')
            ->willReturn(new Success(new Articles()))
        ;

        $worker = new Worker($injector, $articleRepository, new NewArticleManager());

        wait($worker->run(new Feed('id', 'crawler', new \DateInterval('P1D'))));
    }

    public function testRunStoresNewArticlesReturnsCount(): void
    {
        $injector          = $this->createMock(Injector::class);
        $articleRepository = $this->createMock(Repository::class);

        $injector
            ->expects($this->once())
            ->method('execute')
            ->willReturn(new Success(new Articles()))
        ;

        $articleRepository
            ->expects($this->once())
            ->method('storeNewArticles')
            ->willReturn(new Success(new Articles(
                new Article('id', 'sourceId', 'feedId', 'url', 'source', 'title', 'excerpt', new \DateTimeImmutable()),
            )))
        ;

        $worker = new Worker($injector, $articleRepository, new NewArticleManager());

        $count = wait($worker->run(new Feed('id', 'crawler', new \DateInterval('P1D'))));

        $this->assertSame(1, $count);
    }
}
