<?php declare(strict_types = 1);

namespace Contributte\Bus\Utils;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Middleware\IMiddleware;
use Contributte\Bus\Result\Result;

class ChainBuilder
{

	/** @var IMiddleware<Command>[] */
	protected array $middlewares = [];

	/**
	 * @param IMiddleware<Command>[] $middlewares
	 */
	public function __construct(array $middlewares = [])
	{
		$this->middlewares = $middlewares;
	}

	/**
	 * @param IMiddleware<Command>[] $middlewares
	 */
	public static function build(array $middlewares): callable
	{
		return (new self($middlewares))->create();
	}

	/**
	 * @param IMiddleware<Command> $middleware
	 */
	public function add(IMiddleware $middleware): self
	{
		$this->middlewares[] = $middleware;

		return $this;
	}

	/**
	 * @param IMiddleware<Command>[] $middlewares
	 */
	public function addAll(array $middlewares): self
	{
		foreach ($middlewares as $middleware) {
			$this->add($middleware);
		}

		return $this;
	}

	public function create(): callable
	{
		$next = Functions::leaf();

		$middlewares = $this->middlewares;
		while ($middleware = array_pop($middlewares)) {
			$next = fn ($command): Result => $middleware->process($command, $next);
		}

		return $next;
	}

}
