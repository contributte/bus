<?php declare(strict_types = 1);

namespace Tests\Cases\Locator;

use Contributte\Bus\Exception\Runtime\LocatorFailedException;
use Contributte\Bus\Locator\ContainerHandlerLocator;
use Contributte\Tester\Toolkit;
use Contributte\Tester\Utils\ContainerBuilder;
use Contributte\Tester\Utils\Neonkit;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Tester\Assert;
use Tests\Fixtures\DummyCommand;

require_once __DIR__ . '/../../bootstrap.php';

// Locate service
Toolkit::test(static function (): void {
	$container = ContainerBuilder::of()
		->withCompiler(static function (Compiler $compiler): void {
			$compiler->addConfig(Neonkit::load('
				services:
					dummyHandler: Tests\Fixtures\DummyHandler
			'));
		})
		->build();

	$locator = new ContainerHandlerLocator([
		DummyCommand::class => 'dummyHandler',
	], $container);

	Assert::same($container->getByName('dummyHandler'), $locator->find(new DummyCommand()));
});

// Service not found
Toolkit::test(static function (): void {
	$locator = new ContainerHandlerLocator([], new Container());
	Assert::exception(
		static fn () => $locator->find(new DummyCommand()),
		LocatorFailedException::class,
		'Handler for command "Tests\Fixtures\DummyCommand" not found in service map'
	);
});

// Service is not handler
Toolkit::test(static function (): void {
	$container = ContainerBuilder::of()
		->withCompiler(static function (Compiler $compiler): void {
			$compiler->addConfig(Neonkit::load('
				services:
					dummyHandler: stdClass
			'));
		})
		->build();

	$locator = new ContainerHandlerLocator([
		DummyCommand::class => 'dummyHandler',
	], $container);

	Assert::exception(
		static fn () => $locator->find(new DummyCommand()),
		LocatorFailedException::class,
		'Handler for command "Tests\Fixtures\DummyCommand" has invalid type "stdClass"'
	);
});
