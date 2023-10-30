<?php declare(strict_types = 1);

namespace Contributte\Bus\Locator;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Exception\Runtime\LocatorFailedException;
use Contributte\Bus\Handler\IHandler;
use Nette\DI\Container;

/**
 * @implements IHandlerLocator<Command>
 */
class ContainerHandlerLocator implements IHandlerLocator
{

	/** @var array<string, class-string<IHandler<Command>>> */
	protected array $map = [];

	protected Container $container;

	/**
	 * @param array<string, class-string<IHandler<Command>>> $map
	 */
	public function __construct(array $map, Container $container)
	{
		$this->map = $map;
		$this->container = $container;
	}

	/**
	 * @return IHandler<Command>
	 */
	public function find(Command $command): IHandler
	{
		if (!isset($this->map[$command::class])) {
			throw LocatorFailedException::noMapping($command);
		}

		if (!$this->container->hasService($this->map[$command::class])) {
			throw LocatorFailedException::notFound($command);
		}

		$service = $this->container->getByName($this->map[$command::class]);

		if (!($service instanceof IHandler)) {
			throw LocatorFailedException::invalidType($command, $service);
		}

		return $service;
	}

}
