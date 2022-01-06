<?php

declare(strict_types=1);

namespace SixtyEightPublishers\TracyGitVersionPanel\Exception;

use SixtyEightPublishers\TracyGitVersionPanel\Export\ExporterInterface;

final class BadMethodCallException extends \BadMethodCallException implements ExceptionInterface
{
	/**
	 * @param \SixtyEightPublishers\TracyGitVersionPanel\Export\ExporterInterface $exporter
	 *
	 * @return static
	 */
	public static function gitRepositoryNotProvidedForPartialExporter(ExporterInterface $exporter): self
	{
		return new self(sprintf(
			'Git repository for a partial exporter %s must be provided.',
			get_class($exporter)
		));
	}
}