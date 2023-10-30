<?php declare(strict_types = 1);

namespace Contributte\Bus\Result;

/**
 * @phpstan-consistent-constructor
 */
class EmptyResult extends Result
{

	protected function __construct()
	{
		// Secure constructor
	}

	public static function of(): self
	{
		return new static();
	}

}
