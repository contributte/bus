<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Handler\IHandler;
use Contributte\Bus\Result\EmptyResult;
use Contributte\Bus\Result\Result;

final class DummyHandler implements IHandler
{

	public function handle(Command $command): Result
	{
		return new EmptyResult();
	}

}
