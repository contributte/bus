<?php declare(strict_types = 1);

namespace Contributte\Bus\Result;

use Contributte\Bus\Event\Event;
use Contributte\Bus\Exception\LogicException;

/**
 * @phpstan-consistent-constructor
 */
class NullResult extends Result
{

	public function trackEvent(Event $event): Event
	{
		throw new LogicException('Events not implement');
	}

	/**
	 * {@inheritDoc}
	 */
	public function collectEvents(): array
	{
		throw new LogicException('Events not implement');
	}

	/**
	 * {@inheritDoc}
	 */
	public function pullEvents(): array
	{
		throw new LogicException('Events not implement');
	}

	/**
	 * {@inheritDoc}
	 */
	public function clearEvents(): void
	{
		throw new LogicException('Events not implement');
	}

}
