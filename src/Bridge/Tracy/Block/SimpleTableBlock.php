<?php

declare(strict_types=1);

namespace SixtyEightPublishers\TracyGitVersionPanel\Bridge\Tracy\Block;

use SixtyEightPublishers\TracyGitVersionPanel\Bridge\Tracy\Helpers;
use SixtyEightPublishers\TracyGitVersionPanel\Repository\GitRepositoryInterface;

final class SimpleTableBlock implements BlockInterface
{
	private array $rows;

	private ?string $caption;

	/**
	 * @param array       $rows
	 * @param string|NULL $caption
	 */
	public function __construct(array $rows, ?string $caption = NULL)
	{
		$this->rows = $rows;
		$this->caption = $caption;
	}

	/**
	 * {@inheritDoc}
	 */
	public function render(GitRepositoryInterface $gitRepository): string
	{
		return Helpers::renderTemplate(__DIR__ . '/../templates/SimpleTable.block.phtml', [
			'caption' => $this->caption,
			'rows' => $this->rows,
		]);
	}
}
