<?php declare(strict_types = 1);

namespace Contributte\Bus\Middleware;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Locator\IHandlerLocator;
use Contributte\Bus\Result\Result;

/**
 * @implements IMiddleware<Command>
 */
class HandlerMiddleware implements IMiddleware
{

	/** @var IHandlerLocator<Command> */
	protected IHandlerLocator $handlerLocator;

	/**
	 * @param IHandlerLocator<Command> $handlerLocator
	 */
	public function __construct(IHandlerLocator $handlerLocator)
	{
		$this->handlerLocator = $handlerLocator;
	}

	public function process(Command $command, callable $next): Result
	{
		$handler = $this->handlerLocator->find($command);

		return $handler->handle($command);
	}

}
