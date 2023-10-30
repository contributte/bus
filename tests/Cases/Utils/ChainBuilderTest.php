<?php declare(strict_types = 1);

use Contributte\Bus\Result\EmptyResult;
use Contributte\Bus\Utils\ChainBuilder;
use Contributte\Tester\Toolkit;
use Tester\Assert;
use Tests\Fixtures\DummyCommand;
use Tests\Fixtures\DummyMiddleware;

require_once __DIR__ . '/../../bootstrap.php';

// Empty
Toolkit::test(function (): void {
	$chain = (new ChainBuilder())->create();
	Assert::type(EmptyResult::class, $chain());

	$chain = ChainBuilder::build([]);
	Assert::type(EmptyResult::class, $chain());
});

// Simple middleware
Toolkit::test(function (): void {
	$middleware = new DummyMiddleware();

	$builder = new ChainBuilder();
	$builder->add($middleware);

	$command = new DummyCommand();

	$chain = $builder->create();
	$return = $chain($command);

	Assert::same($command, $middleware->command);
	Assert::same($return, $middleware->result);
});
