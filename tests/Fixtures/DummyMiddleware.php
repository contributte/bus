<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Middleware\IMiddleware;
use Contributte\Bus\Result\Result;

final class DummyMiddleware implements IMiddleware
{

	public ?Command $command;

	public ?Result $result;

	public function process(Command $command, callable $next): Result
	{
		$this->command = $command;
		$ret = $next($command);
		$this->result = $ret;

		return $ret;
	}

}
