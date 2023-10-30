<?php declare(strict_types = 1);

namespace Contributte\Bus\Handler;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Result\Result;

/**
 * @template T of Command
 */
interface IHandler
{

	/**
	 * @param T $command
	 */
	public function handle(Command $command): Result;

}
