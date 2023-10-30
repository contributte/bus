<?php declare(strict_types = 1);

namespace Contributte\Bus\Exception\Runtime;

use Contributte\Bus\Command\Command;
use Contributte\Bus\Exception\RuntimeException;

class LocatorFailedException extends RuntimeException
{

	public Command $command;

	public static function notFound(Command $command): self
	{
		$self = new self(sprintf('Handler for command "%s" not found', $command::class));
		$self->command = $command;

		return $self;
	}

	public static function invalidType(Command $command, object $service): self
	{
		$self = new self(sprintf('Handler for command "%s" has invalid type "%s"', $command::class, $service::class));
		$self->command = $command;

		return $self;
	}

	public static function noMapping(Command $command): self
	{
		$self = new self(sprintf('Handler for command "%s" not found in service map', $command::class));
		$self->command = $command;

		return $self;
	}

}
