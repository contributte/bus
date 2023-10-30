<?php declare(strict_types = 1);

namespace Contributte\Bus\Result;

use Contributte\Bus\Event\Event;

class Result
{

	/** @var array<Event> */
	protected array $events = [];

	public function trackEvent(Event $event): Event
	{
		$this->events[] = $event;

		return $event;
	}

	/**
	 * @return Event[]
	 */
	public function collectEvents(): array
	{
		return $this->events;
	}

	/**
	 * @return Event[]
	 */
	public function pullEvents(): array
	{
		$events = $this->collectEvents();
		$this->clearEvents();

		return $events;
	}

	public function clearEvents(): void
	{
		$this->events = [];
	}

}
