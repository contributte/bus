<?php declare(strict_types = 1);

namespace Contributte\Bus\Middleware;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Result\Result;

/**
 * @template T of Command
 */
interface IMiddleware
{

	/**
	 * @param T $command
	 * @param callable(T): Result $next
	 */
	public function process(Command $command, callable $next): Result;

}
