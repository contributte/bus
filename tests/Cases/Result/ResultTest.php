<?php declare(strict_types = 1);

use Contributte\Bus\Result\Result;
use Contributte\Tester\Toolkit;
use Tester\Assert;
use Tests\Fixtures\DummyEvent;

require_once __DIR__ . '/../../bootstrap.php';

// Events
Toolkit::test(function (): void {
	$event = new DummyEvent();

	$result = new Result();
	$result->trackEvent($event);
	$result->trackEvent($event);

	Assert::count(2, $result->collectEvents());
	Assert::equal([$event, $event], $result->pullEvents());
	Assert::count(0, $result->collectEvents());

	$result = new Result();
	$result->trackEvent($event);
	$result->trackEvent($event);

	Assert::count(2, $result->collectEvents());
	$result->clearEvents();
	Assert::count(0, $result->collectEvents());
});
