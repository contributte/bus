<?php declare(strict_types = 1);

namespace Contributte\Bus\Locator;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Handler\IHandler;

/**
 * @template T of Command
 */
interface IHandlerLocator
{

	/**
	 * @param T $command
	 * @return IHandler<T>
	 */
	public function find(Command $command): IHandler;

}
