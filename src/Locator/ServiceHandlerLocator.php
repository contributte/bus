<?php declare(strict_types = 1);

namespace Contributte\Bus\Locator;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Exception\Runtime\LocatorFailedException;
use Contributte\Bus\Handler\IHandler;

/**
 * @implements IHandlerLocator<Command>
 */
class ServiceHandlerLocator implements IHandlerLocator
{

	/** @var array<string, object> */
	protected array $services = [];

	/**
	 * @param array<string, object> $services
	 */
	public function __construct(array $services)
	{
		$this->services = $services;
	}

	/**
	 * @return IHandler<Command>
	 */
	public function find(Command $command): IHandler
	{
		$service = $this->services[$command::class] ?? null;

		if ($service === null) {
			throw LocatorFailedException::notFound($command);
		}

		if (!($service instanceof IHandler)) {
			throw LocatorFailedException::invalidType($command, $service);
		}

		return $service;
	}

}
