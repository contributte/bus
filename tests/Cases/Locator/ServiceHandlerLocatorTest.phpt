<?php declare(strict_types = 1);

namespace Tests\Cases\Locator;

use Contributte\Bus\Exception\Runtime\LocatorFailedException;
use Contributte\Bus\Locator\ServiceHandlerLocator;
use Contributte\Tester\Toolkit;
use stdClass;
use Tester\Assert;
use Tests\Fixtures\DummyCommand;
use Tests\Fixtures\DummyHandler;

require_once __DIR__ . '/../../bootstrap.php';

// Locate service
Toolkit::test(static function (): void {
	$service = new DummyHandler();

	$locator = new ServiceHandlerLocator([
		DummyCommand::class => $service,
	]);

	Assert::same($service, $locator->find(new DummyCommand()));
});

// Service not found
Toolkit::test(static function (): void {
	$locator = new ServiceHandlerLocator([]);
	Assert::exception(
		static fn () => $locator->find(new DummyCommand()),
		LocatorFailedException::class,
		'Handler for command "Tests\Fixtures\DummyCommand" not found'
	);
});

// Service is not handler
Toolkit::test(static function (): void {
	$service = new stdClass();

	$locator = new ServiceHandlerLocator([
		DummyCommand::class => $service,
	]);

	Assert::exception(
		static fn () => $locator->find(new DummyCommand()),
		LocatorFailedException::class,
		'Handler for command "Tests\Fixtures\DummyCommand" has invalid type "stdClass"'
	);
});
