<?php

declare(strict_types=1);

namespace SixtyEightPublishers\TracyGitVersionPanel\Repository\LocalDirectory\CommandHandler;

use SixtyEightPublishers\TracyGitVersionPanel\Exception\GitDirectoryException;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\LocalDirectory\GitDirectory;

abstract class AbstractLocalDirectoryCommandHandler implements LocalDirectoryGitCommandHandlerInterface
{
	private ?GitDirectory $gitDirectory;

	/**
	 * @param \SixtyEightPublishers\TracyGitVersionPanel\Repository\LocalDirectory\GitDirectory|NULL $gitDirectory
	 */
	public function __construct(?GitDirectory $gitDirectory = NULL)
	{
		$this->gitDirectory = $gitDirectory;
	}

	/**
	 * {@inheritDoc}
	 */
	public function withGitDirectory(GitDirectory $gitDirectory): LocalDirectoryGitCommandHandlerInterface
	{
		return new static($gitDirectory);
	}

	/**
	 * @return \SixtyEightPublishers\TracyGitVersionPanel\Repository\LocalDirectory\GitDirectory
	 * @throws \SixtyEightPublishers\TracyGitVersionPanel\Exception\GitDirectoryException
	 */
	protected function getGitDirectory(): GitDirectory
	{
		if (NULL === $this->gitDirectory) {
			throw GitDirectoryException::gitDirectoryNotProvided();
		}

		return $this->gitDirectory;
	}
}
