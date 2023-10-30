<?php declare(strict_types = 1);

use Contributte\Bus\Handler\IHandler;
use Contributte\Bus\Locator\IHandlerLocator;
use Contributte\Bus\Middleware\HandlerMiddleware;
use Contributte\Bus\Result\DataResult;
use Contributte\Bus\Utils\Functions;
use Contributte\Tester\Toolkit;
use Tester\Assert;
use Tests\Fixtures\DummyCommand;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::tearDown(fn () => Mockery::close());

// E2E
Toolkit::test(function (): void {
	$command = new DummyCommand();

	$handler = $locator = Mockery::mock(IHandler::class);
	$locator->shouldReceive('handle')
		->once()
		->andReturn(DataResult::ofScalar(true));

	$locator = Mockery::mock(IHandlerLocator::class);
	$locator->shouldReceive('find')
		->once()
		->andReturn($handler);

	$middleware = new HandlerMiddleware($locator);
	$return = $middleware->process($command, Functions::leaf());

	Assert::type(DataResult::class, $return);
	Assert::equal(true, $return->getData());
});
