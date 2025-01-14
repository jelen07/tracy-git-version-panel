<?php

declare(strict_types=1);

namespace SixtyEightPublishers\TracyGitVersionPanel\Repository\Entity;

final class CommitHash
{
	private string $value;

	/**
	 * @param string $value
	 */
	public function __construct(string $value)
	{
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @param \SixtyEightPublishers\TracyGitVersionPanel\Repository\Entity\CommitHash $commitHash
	 *
	 * @return bool
	 */
	public function compare(self $commitHash): bool
	{
		return $this->getValue() === $commitHash->getValue();
	}
}
