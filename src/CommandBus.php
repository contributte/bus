<?php declare(strict_types = 1);

namespace Contributte\Bus;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Middleware\IMiddleware;
use Contributte\Bus\Result\NullResult;
use Contributte\Bus\Result\Result;
use Contributte\Bus\Utils\ChainBuilder;

class CommandBus
{

	/** @var IMiddleware<Command>[] */
	protected array $middlewares = [];

	/** @var callable|null */
	protected $chain = null;

	protected bool $chained = false;

	/**
	 * @param IMiddleware<Command>[] $middlewares
	 */
	public function __construct(array $middlewares = [])
	{
		$this->middlewares = $middlewares;
	}

	/**
	 * @param IMiddleware<Command> $middleware
	 */
	public function tap(IMiddleware $middleware): self
	{
		$this->middlewares[] = $middleware;

		// Reset already built chain of middlewares
		$this->chain = null;

		return $this;
	}

	public function handle(Command $command): Result
	{
		// Create or obtain command bus chain
		$chain = $this->chain ??= $this->createChain();

		// Execute chain and get result
		$return = $chain($command);

		// No result, thus create result manually
		if ($return === null) {
			return new NullResult();
		}

		return $return;
	}

	protected function createChain(): callable
	{
		return ChainBuilder::build($this->middlewares);
	}

}
