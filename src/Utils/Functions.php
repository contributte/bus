<?php declare(strict_types = 1);

namespace Contributte\Bus\Utils;

use Contributte\Bus\Result\EmptyResult;
use Contributte\Bus\Result\Result;

final class Functions
{

	public static function blank(): callable
	{
		return function (): void {
			// Empty function
		};
	}

	public static function leaf(): callable
	{
		return fn (): Result => EmptyResult::of();
	}

}
