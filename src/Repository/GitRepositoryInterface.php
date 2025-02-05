<?php

declare(strict_types=1);

namespace SixtyEightPublishers\TracyGitVersionPanel\Repository;

interface GitRepositoryInterface
{
	public const SOURCE_GIT_DIRECTORY = 'git directory';
	public const SOURCE_EXPORT = 'export';

	/**
	 * @return string
	 */
	public function getSource(): string;

	/**
	 * @return bool
	 */
	public function isAccessible(): bool;

	/**
	 * @param string                                                                           $commandClassname
	 * @param \SixtyEightPublishers\TracyGitVersionPanel\Repository\GitCommandHandlerInterface $handler
	 *
	 * @return void
	 */
	public function addHandler(string $commandClassname, GitCommandHandlerInterface $handler): void;

	/**
	 * @param \SixtyEightPublishers\TracyGitVersionPanel\Repository\GitCommandInterface $command
	 *
	 * @return mixed
	 * @throws \SixtyEightPublishers\TracyGitVersionPanel\Exception\UnhandledCommandException
	 */
	public function handle(GitCommandInterface $command);

	/**
	 * @param string $commandClassname
	 *
	 * @return bool
	 */
	public function supports(string $commandClassname): bool;
}
