<?php

declare(strict_types=1);

namespace SixtyEightPublishers\TracyGitVersionPanel\Repository;

final class RuntimeCachedGitRepository implements GitRepositoryInterface
{
	private GitRepositoryInterface $inner;

	private array $cache = [];

	/**
	 * @param \SixtyEightPublishers\TracyGitVersionPanel\Repository\GitRepositoryInterface $inner
	 */
	public function __construct(GitRepositoryInterface $inner)
	{
		$this->inner = $inner;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getSource(): string
	{
		return $this->inner->getSource();
	}

	/**
	 * {@inheritDoc}
	 */
	public function isAccessible(): bool
	{
		return $this->inner->isAccessible();
	}

	/**
	 * {@inheritDoc}
	 */
	public function addHandler(string $commandClassname, GitCommandHandlerInterface $handler): void
	{
		$this->inner->addHandler($commandClassname, $handler);
	}

	/**
	 * {@inheritDoc}
	 */
	public function handle(GitCommandInterface $command)
	{
		$commandId = (string) $command;

		return $this->cache[$commandId] ?? $this->cache[$commandId] = $this->inner->handle($command);
	}

	/**
	 * {@inheritDoc}
	 */
	public function supports(string $commandClassname): bool
	{
		return $this->inner->supports($commandClassname);
	}
}
