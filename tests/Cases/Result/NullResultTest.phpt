<?php declare(strict_types = 1);

namespace Tests\Cases\Result;

use Contributte\Bus\Result\NullResult;
use Contributte\Tester\Toolkit;
use LogicException;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(static function (): void {
	$result = new NullResult();

	Assert::exception(
		static fn () => $result->pullEvents(),
		LogicException::class
	);
});
