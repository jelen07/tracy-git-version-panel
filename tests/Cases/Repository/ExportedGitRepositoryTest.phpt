<?php

declare(strict_types=1);

namespace SixtyEightPublishers\TracyGitVersionPanel\Tests\Cases\Repository;

use Tester\Assert;
use Tester\TestCase;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\LocalGitRepository;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\ExportedGitRepository;
use SixtyEightPublishers\TracyGitVersionPanel\Tests\Fixtures\Command\BarCommand;
use SixtyEightPublishers\TracyGitVersionPanel\Tests\Fixtures\Command\FooCommand;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\Command\GetHeadCommand;
use SixtyEightPublishers\TracyGitVersionPanel\Exception\UnhandledCommandException;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\LocalDirectory\GitDirectory;
use SixtyEightPublishers\TracyGitVersionPanel\Tests\Fixtures\CommandHandler\ExportedFooCommandHandler;
use SixtyEightPublishers\TracyGitVersionPanel\Tests\Fixtures\CommandHandler\LocalDirectoryFooCommandHandler;
use SixtyEightPublishers\TracyGitVersionPanel\Tests\Fixtures\CommandHandler\BarCommandHandler;

require __DIR__ . '/../../bootstrap.php';

final class ExportedGitRepositoryTest extends TestCase
{
	public function testRepositorySource() : void
	{
		$repository = $this->createValidGitRepository([]);

		Assert::same('test', $repository->getSource());
	}

	public function testIsAccessibleMethod() : void
	{
		$repository = $this->createValidGitRepository([]);

		Assert::true($repository->isAccessible());

		$repository = $this->createInvalidGitRepository([]);

		Assert::false($repository->isAccessible());
	}

	public function testSupportsMethod() : void
	{
		$handlers = [
			FooCommand::class => new ExportedFooCommandHandler(),
			BarCommand::class => new BarCommandHandler(),
		];

		# do assertions on valid repository
		$repository = $this->createValidGitRepository($handlers);

		Assert::true($repository->supports(FooCommand::class));
		Assert::true($repository->supports(BarCommand::class));
		Assert::false($repository->supports('BazCommand'));

		# do assertions on invalid repository
		$repository = $this->createInvalidGitRepository($handlers);

		Assert::false($repository->supports(FooCommand::class));
		Assert::false($repository->supports(BarCommand::class));
		Assert::false($repository->supports('BazCommand'));
	}

	public function testCommandHandling() : void
	{
		# prepare commands and handlers
		$handlers = [
			FooCommand::class => new ExportedFooCommandHandler(),
			BarCommand::class => new BarCommandHandler(),
		];

		$fooCommand = new FooCommand();
		$barCommand = new BarCommand(100);

		# do assertions on valid repository
		$repository = $this->createValidGitRepository($handlers);

		Assert::same('FOO', $repository->handle($fooCommand));
		Assert::same(200, $repository->handle($barCommand));

		$unhandledCommand = new GetHeadCommand();

		Assert::exception(
			static function () use ($repository, $unhandledCommand) {
				$repository->handle($unhandledCommand);
			},
			UnhandledCommandException::class,
			sprintf('Can\'t handle git command %s.', $unhandledCommand)
		);

		# do assertions on invalid repository
		$repository = $this->createInvalidGitRepository($handlers);

		Assert::exception(
			static function () use ($repository, $fooCommand) {
				$repository->handle($fooCommand);
			},
			UnhandledCommandException::class,
			sprintf('Can\'t handle git command %s.', $fooCommand)
		);

		Assert::exception(
			static function () use ($repository, $barCommand) {
				$repository->handle($barCommand);
			},
			UnhandledCommandException::class,
			sprintf('Can\'t handle git command %s.', $barCommand)
		);
	}

	/**
	 * @param array $handlers
	 *
	 * @return \SixtyEightPublishers\TracyGitVersionPanel\Repository\ExportedGitRepository
	 */
	private function createValidGitRepository(array $handlers) : ExportedGitRepository
	{
		return new ExportedGitRepository(__DIR__ . '/../../files/export/test.json', $handlers, 'test');
	}

	/**
	 * @param array $handlers
	 *
	 * @return \SixtyEightPublishers\TracyGitVersionPanel\Repository\ExportedGitRepository
	 */
	private function createInvalidGitRepository(array $handlers) : ExportedGitRepository
	{
		return new ExportedGitRepository(__DIR__ . '/../../files/export/non-existent-export.json', $handlers, 'test');
	}
}

(new ExportedGitRepositoryTest())->run();
