<?php

declare(strict_types=1);

namespace SixtyEightPublishers\TracyGitVersionPanel\Tests\Cases\Repository\Export\CommandHandler;

use Tester\Assert;
use Tester\TestCase;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\Entity\Head;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\Command\GetHeadCommand;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\Export\CommandHandler\GetHeadCommandHandler;

require __DIR__ . '/../../../../bootstrap.php';

final class GetHeadCommandHandlerTest extends TestCase
{
	public function testCommandHandling(): void
	{
		$handler = new GetHeadCommandHandler([
			'head' => [
				'branch' => 'master',
				'commit_hash' => '59d7c7f0e34f4db5ba7f5c28e3eb4630339d4382',
			],
		]);
		$head = $handler(new GetHeadCommand());

		Assert::type(Head::class, $head);
		Assert::same('master', $head->getBranch());
		Assert::same('59d7c7f0e34f4db5ba7f5c28e3eb4630339d4382', $head->getCommitHash()->getValue());
		Assert::false($head->isDetached());
	}

	public function testCommandHandlingOnDetachedHead(): void
	{
		$handler = new GetHeadCommandHandler([
			'head' => [
				'branch' => NULL,
				'commit_hash' => '3416c5b1831774dd209e489100b3a7c1e333690d',
			],
		]);
		$head = $handler(new GetHeadCommand());

		Assert::type(Head::class, $head);
		Assert::null($head->getBranch());
		Assert::same('3416c5b1831774dd209e489100b3a7c1e333690d', $head->getCommitHash()->getValue());
		Assert::true($head->isDetached());
	}
}

(new GetHeadCommandHandlerTest())->run();
