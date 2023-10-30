<?php declare(strict_types = 1);

use Contributte\Bus\CommandBus;
use Contributte\Bus\Exception\Runtime\LocatorFailedException;
use Contributte\Bus\Locator\ServiceHandlerLocator;
use Contributte\Bus\Middleware\HandlerMiddleware;
use Contributte\Bus\Result\EmptyResult;
use Contributte\Tester\Toolkit;
use Tester\Assert;
use Tests\Fixtures\DummyCommand;
use Tests\Fixtures\DummyHandler;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::tearDown(fn () => Mockery::close());

// No middlewares
Toolkit::test(function (): void {
	$bus = new CommandBus();
	$result = $bus->handle(new DummyCommand());

	Assert::type(EmptyResult::class, $result);
});

// Handler middleware
Toolkit::test(function (): void {
	$handler = new DummyHandler();

	$bus = new CommandBus();
	$bus->tap(
		new HandlerMiddleware(
			new ServiceHandlerLocator([
				DummyCommand::class => $handler,
			])
		)
	);

	$result = $bus->handle(new DummyCommand());
	Assert::type(EmptyResult::class, $result);
});

// Handler middleware - no handler
Toolkit::test(function (): void {
	$bus = new CommandBus();
	$bus->tap(
		new HandlerMiddleware(
			new ServiceHandlerLocator([])
		)
	);

	Assert::exception(
		fn () => $bus->handle(new DummyCommand()),
		LocatorFailedException::class,
		'Handler for command "Tests\Fixtures\DummyCommand" not found'
	);
});

// Creating chain only once
Toolkit::test(function (): void {
	$bus = Mockery::mock(CommandBus::class)
		->shouldAllowMockingProtectedMethods()
		->makePartial();
	$bus->shouldReceive('createChain')
		->once()
		->passthru();

	$bus->handle(new DummyCommand());
	$bus->handle(new DummyCommand());
});
